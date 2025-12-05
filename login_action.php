<?php
session_start(); // MUST be first

require 'db.php'; // defines $mysqli

function go($msg) {
  header("Location: login.php?msg=" . urlencode($msg));
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  go("Invalid request");
}

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$captcha  = trim($_POST['captcha'] ?? '');

if ($email === '' || $password === '' || $captcha === '') {
  go("All fields are required");
}

// CAPTCHA check
if (!isset($_SESSION['captcha'])) go("Captcha expired. Reload page.");
if (strcasecmp($captcha, $_SESSION['captcha']) !== 0) {
  unset($_SESSION['captcha']);
  go("Invalid captcha");
}
unset($_SESSION['captcha']);

// --- Determine which name column(s) exist in the users table ---
$columns = [];
$colQ = $mysqli->query("SHOW COLUMNS FROM `users`");
if ($colQ) {
  while ($r = $colQ->fetch_assoc()) {
    $columns[] = $r['Field'];
  }
  $colQ->free_result();
} else {
  // If SHOW COLUMNS fails, log and continue with a safe fallback
  error_log("SHOW COLUMNS failed for users table: " . $mysqli->error);
}

// Decide which SELECT to run. We'll always select id, email, password and a computed full_name column.
$selectSql = "";
if (in_array('full_name', $columns, true)) {
  $selectSql = "SELECT id, full_name, email, password FROM users WHERE email = ? LIMIT 1";
} elseif (in_array('name', $columns, true)) {
  $selectSql = "SELECT id, name AS full_name, email, password FROM users WHERE email = ? LIMIT 1";
} elseif (in_array('first_name', $columns, true) && in_array('last_name', $columns, true)) {
  // CONCAT may be empty if either part is NULL; use IFNULL to avoid NULL result
  $selectSql = "SELECT id, CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,'')) AS full_name, email, password FROM users WHERE email = ? LIMIT 1";
} else {
  // No name columns exist — select an empty full_name so $user['full_name'] is defined
  $selectSql = "SELECT id, '' AS full_name, email, password FROM users WHERE email = ? LIMIT 1";
}

// Prepare and execute safely
$stmt = $mysqli->prepare($selectSql);
if (!$stmt) {
  error_log("Prepare failed in login_action: " . $mysqli->error);
  go("Database error");
}

$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
  // It's safer to return a generic message so attackers can't probe which emails exist
  go("Invalid credentials");
}

$user = $res->fetch_assoc();
$dbPass = $user['password'] ?? '';

// Password check (supports bcrypt/argon or plain text fallback)
$isHashed = (is_string($dbPass) && (str_starts_with($dbPass, '$2y$') || str_starts_with($dbPass, '$2a$') || stripos($dbPass, '$argon') === 0));
$valid = false;
if ($isHashed) {
  $valid = password_verify($password, $dbPass);
} else {
  // plain-text fallback (not recommended long-term)
  $valid = ($password === $dbPass);
}

if (!$valid) go("Invalid credentials");

// Set session
session_regenerate_id(true);
$_SESSION['user_id']    = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name']  = $user['full_name']; // will be '' if table had no name columns

// Redirect
header("Location: tender_form.php");
exit;
  