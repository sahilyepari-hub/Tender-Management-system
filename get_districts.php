<?php
include 'db.php';

$state_id = isset($_GET['state_id']) ? intval($_GET['state_id']) : 0;
echo "<option value=''>Select District</option>";

if ($state_id > 0) {
    $res = $mysqli->query("SELECT id, name FROM districts WHERE state_id = $state_id ORDER BY name");
    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
    }
}
?>