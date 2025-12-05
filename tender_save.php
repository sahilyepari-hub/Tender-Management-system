<?php
// tender_save.php - production-safe, dynamic column mapping
require 'auth.php';
require 'db.php'; // provides $mysqli

function bad($msg) {
  header('Location: tender_form.php?msg=' . urlencode($msg));
  exit;
}

// Minimal required POST keys (form must send these)
$required = [
  'type','full_name','mobile','email',
  'license_number','gst_number',
  'goods_type','goods_demand','sale_rate',
  'state_id','district_id'
];
foreach ($required as $k) {
  if (!isset($_POST[$k]) || trim($_POST[$k]) === '') {
    bad("Please fill required field: $k");
  }
}

// sanitize mobile and pincode early
$mobile_raw = isset($_POST['mobile']) ? $_POST['mobile'] : '';
$mobile = preg_replace('/\D+/', '', trim($mobile_raw)); // digits only

if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
    bad('Mobile must start with 6, 7, 8 or 9 and be exactly 10 digits');
}

$pincode_raw = isset($_POST['pincode']) ? $_POST['pincode'] : '';
$pincode = preg_replace('/\D+/', '', trim($pincode_raw));
if (!preg_match('/^\d{6}$/', $pincode)) {
  bad('Pincode must be exactly 6 digits');
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) bad('Invalid email');

// upload helper (required files)
function validateUpload($key) {
  if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
    return [false, "File required: $key"];
  }
  $f = $_FILES[$key];
  $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
  if (!in_array($ext, ['jpg','jpeg','png'])) return [false, "Only JPG/JPEG/PNG allowed for $key"];
  if ($f['size'] > 2 * 1024 * 1024) return [false, "Max 2MB allowed for $key"];
  $uploadDir = __DIR__ . '/uploads/tenders';
  if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
  $fileName = $key . '_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
  $relPath = 'uploads/tenders/' . $fileName;
  $fullPath = __DIR__ . '/' . $relPath;
  if (!move_uploaded_file($f['tmp_name'], $fullPath)) return [false, "Upload failed for $key"];
  return [true, $relPath];
}

// validate uploads (keep required per your form)
list($okPhoto, $photo)     = validateUpload('photo');           if (!$okPhoto) bad($photo);
list($okAadhar, $aadhar)   = validateUpload('aadhar_copy');     if (!$okAadhar) bad($aadhar);
list($okPan, $pan)         = validateUpload('pan_copy');        if (!$okPan) bad($pan);
list($okGst, $gstc)        = validateUpload('gst_certificate'); if (!$okGst) bad($gstc);
list($okLic, $licc)        = validateUpload('license_certificate'); if (!$okLic) bad($licc);

// sanitize inputs (use both possible taluka names)
$type           = trim($_POST['type']);
$full_name      = trim($_POST['full_name']);
$address        = isset($_POST['address']) ? trim($_POST['address']) : '';
$city           = isset($_POST['city']) ? trim($_POST['city']) : '';
$district_id    = isset($_POST['district_id']) ? (int) $_POST['district_id'] : 0;
$state_id       = isset($_POST['state_id']) ? (int) $_POST['state_id'] : 0;
$license_number = trim($_POST['license_number']);
$gst_number     = trim($_POST['gst_number']);
$goods_type     = trim($_POST['goods_type']);
$goods_demand   = trim($_POST['goods_demand']);
$sale_rate      = trim($_POST['sale_rate']);
$remarks        = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
$taluka_name    = isset($_POST['taluka_name']) ? trim($_POST['taluka_name']) : (isset($_POST['taluka']) ? trim($_POST['taluka']) : '');

// Build a mapping of possible column => value (strings or ints)
$valueMap = [
  'type' => $type,
  'full_name' => $full_name,
  'address' => $address,
  'city' => $city,
  'district_id' => $district_id,
  'state_id' => $state_id,
  'pincode' => $pincode,
  'mobile' => $mobile,
  'email' => $email,
  'license_number' => $license_number,
  'gst_number' => $gst_number,
  'goods_type' => $goods_type,
  'goods_demand' => $goods_demand,
  'sale_rate' => $sale_rate,
  'photo' => $photo,
  'aadhar_copy' => $aadhar,
  'pan_copy' => $pan,
  'gst_certificate' => $gstc,
  'license_certificate' => $licc,
  'remarks' => $remarks,
  'taluka' => $taluka_name,
];

// Get actual columns from the tenders table
$colsRes = $mysqli->query("SHOW COLUMNS FROM tenders");
if (!$colsRes) {
  bad("DB error reading table columns: " . $mysqli->error);
}

$cols = [];
while ($c = $colsRes->fetch_assoc()) {
  $colName = $c['Field'];
  if (in_array($colName, ['id','created_at'])) continue;
  $cols[] = $colName;
}

// Build insert column list and values in exact order found
$insertCols = [];
$insertVals = [];
foreach ($cols as $col) {
  if (array_key_exists($col, $valueMap)) {
    $insertCols[] = $col;
    $insertVals[] = $valueMap[$col];
  } else {
    $insertCols[] = $col;
    $insertVals[] = '';
  }
}

if (count($insertCols) !== count($insertVals)) {
  bad("Internal error: column/value count mismatch.");
}

$placeholders = implode(',', array_fill(0, count($insertCols), '?'));
$colList = implode(',', $insertCols);
$sql = "INSERT INTO tenders ($colList) VALUES ($placeholders)";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
  bad("DB prepare failed: " . $mysqli->error);
}

$types = '';
foreach ($insertCols as $c) {
  if (in_array($c, ['district_id','state_id'])) $types .= 'i';
  else $types .= 's';
}

$params = array_merge([$types], $insertVals);
$refs = [];
foreach ($params as $k => $v) $refs[$k] = &$params[$k];
call_user_func_array([$stmt, 'bind_param'], $refs);

if (!$stmt->execute()) {
  bad("DB execute failed: " . $stmt->error);
}

$stmt->close();
header('Location: report.php?msg=' . urlencode('Tender saved successfully'));
exit;
