<?php
require 'auth.php';
require 'db.php';

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { die("Invalid tender ID"); }

$stmt = $mysqli->prepare("UPDATE tenders SET
  type=?, full_name=?, mobile=?, email=?, goods_type=?, goods_demand=?, sale_rate=?, remarks=?
WHERE id=?");

$stmt->bind_param("ssssssssi",
  $_POST['type'], $_POST['full_name'], $_POST['mobile'], $_POST['email'],
  $_POST['goods_type'], $_POST['goods_demand'], $_POST['sale_rate'], $_POST['remarks'],
  $id
);

if (!$stmt->execute()) {
  die("Update failed: " . $stmt->error);
}

header('Location: report.php?msg=' . urlencode('Tender updated successfully'));
exit;