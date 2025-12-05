<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Detect current file name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SETTribe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="index.php">TenderSphere</a>

    <div class="ms-auto d-flex gap-2">

      <?php if (!isset($_SESSION['user_id'])): ?>

        <?php if ($current_page == 'login.php' || $current_page == 'register.php'): ?>
          <a href="index.php" class="btn btn-outline-secondary btn-sm">Home</a>
        <?php endif; ?>

        <a href="register.php" class="btn btn-outline-secondary btn-sm">Register</a>
        <a href="login.php" class="btn btn-primary btn-sm">Login</a>

      <?php else: ?>

        <a href="tender_form.php" class="btn btn-outline-primary btn-sm">New Tender</a>
        <a href="report.php" class="btn btn-primary btn-sm">Report</a>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>

      <?php endif; ?>

    </div>
  </div>
</nav>
<div class="container py-4">
