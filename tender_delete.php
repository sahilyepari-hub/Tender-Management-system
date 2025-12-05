<?php
require 'auth.php';
require 'db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
  header('Location: report.php?msg=Invalid tender');
  exit;
}

$stmt = $mysqli->prepare("DELETE FROM tenders WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: report.php?msg='.urlencode('Tender deleted'));
exit;