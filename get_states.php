<?php
include 'db.php';

echo "<option value=''>Select State</option>";

$res = $mysqli->query("SELECT id, name FROM states ORDER BY name");
while ($row = $res->fetch_assoc()) {
    echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
}
?>