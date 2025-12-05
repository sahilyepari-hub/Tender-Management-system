<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "settribe_db";

$backup_dir = __DIR__ . "/backups";

if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

$filename = "backup_" . date("Y-m-d_H-i-s") . ".sql";
$file_path = $backup_dir . "/" . $filename;

// Path to mysqldump
$mysqldump = "C:/xampp/mysql/bin/mysqldump.exe";

// Run backup
$cmd = "\"$mysqldump\" -u $db_user $db_name > \"$file_path\"";
system($cmd);

// Send file to browser
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
header('Content-Length: ' . filesize($file_path));

readfile($file_path);
exit;
?>
