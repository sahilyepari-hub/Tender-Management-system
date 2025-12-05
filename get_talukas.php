<?php
// get_talukas.php
include 'db.php'; // provides $mysqli

$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;
echo "<option value=''>Select Taluka</option>";

if ($district_id > 0) {
    $stmt = $mysqli->prepare("SELECT id, name FROM talukas WHERE district_id = ? ORDER BY name");
    $stmt->bind_param("i", $district_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        // return option value = name so we can avoid DB schema changes
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        echo "<option value=\"{$name}\">{$name}</option>";
    }
    $stmt->close();
}
?>
