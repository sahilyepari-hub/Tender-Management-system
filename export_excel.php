<?php
// export_excel.php
require 'auth.php';
require 'db.php'; // provides $mysqli

// filename with timestamp
$filename = 'tenders_export_' . date('Ymd_His') . '.csv';

// Query: join state/district names (and use taluka column if present)
$sql = "
  SELECT
    t.id,
    t.type,
    t.full_name,
    t.mobile,
    t.email,
    t.address,
    t.city,
    COALESCE(d.name, '') AS district_name,
    COALESCE(s.name, '') AS state_name,
    t.pincode,
    t.license_number,
    t.gst_number,
    t.goods_type,
    t.goods_demand,
    t.sale_rate,
    t.created_at,
    t.photo,
    t.aadhar_copy,
    t.pan_copy,
    t.gst_certificate,
    t.license_certificate,
    COALESCE(t.taluka, '') AS taluka_name,
    t.remarks
  FROM tenders t
  LEFT JOIN states s ON t.state_id = s.id
  LEFT JOIN districts d ON t.district_id = d.id
  ORDER BY t.created_at DESC
";

if (!($res = $mysqli->query($sql))) {
    // Safe error message in CSV form
    header('Content-Type: text/plain; charset=utf-8');
    echo "Database error: " . $mysqli->error;
    exit;
}

// Send CSV headers so browser downloads file as Excel-compatible CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// UTF-8 BOM so Excel (Windows) opens UTF-8 correctly
echo "\xEF\xBB\xBF";

// open php output stream for fputcsv
$out = fopen('php://output', 'w');

// Header row (column titles)
$headers = [
  'ID','Type','Full Name','Mobile','Email','Address','City','Taluka',
  'District','State','Pincode','License','GST','Goods Type','Goods Demand',
  'Sale Rate','Photo','Aadhar Copy','PAN Copy','GST Certificate','License Certificate',
  'Remarks','Created At'
];
fputcsv($out, $headers);

// Write rows
while ($row = $res->fetch_assoc()) {
    // map row columns to same order as $headers
    $csvRow = [
      $row['id'],
      $row['type'],
      $row['full_name'],
      $row['mobile'],
      $row['email'],
      $row['address'],
      $row['city'],
      $row['taluka_name'],
      $row['district_name'],
      $row['state_name'],
      $row['pincode'],
      $row['license_number'],
      $row['gst_number'],
      $row['goods_type'],
      $row['goods_demand'],
      $row['sale_rate'],
      $row['photo'],
      $row['aadhar_copy'],
      $row['pan_copy'],
      $row['gst_certificate'],
      $row['license_certificate'],
      $row['remarks'],
      $row['created_at']
    ];

    // ensure strings are safe; fputcsv will handle quoting
    fputcsv($out, $csvRow);
}

fclose($out);
exit;
