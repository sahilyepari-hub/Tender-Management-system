<?php
require 'auth.php';
require 'db.php';

// select tenders joined with state/district names
$sql = "SELECT
          t.id, t.type, t.full_name, t.address, t.city,
          t.pincode, t.mobile, t.email, t.license_number, t.gst_number,
          t.goods_type, t.goods_demand, t.sale_rate, t.photo, t.created_at,
          s.name AS state_name, d.name AS district_name
        FROM tenders t
        LEFT JOIN states s ON t.state_id = s.id
        LEFT JOIN districts d ON t.district_id = d.id
        ORDER BY t.created_at DESC";
$result = $mysqli->query($sql);

if (!$result) {
  die("Database query failed: " . $mysqli->error);
}
?>
<?php include 'header.php'; ?>
<div class="container mt-4">
  <h4 class="mb-3">Submitted Tenders</h4>

  <?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-between mb-3">
    <a href="tender_form.php" class="btn btn-success">➕ New Tender</a>
    <a href="export_excel.php" class="btn btn-info">Export to Excel</a>
  </div>

  <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
    <table class="table table-bordered table-hover table-striped table-sm align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th style="width:80px;">ID</th>
          <th>Type</th>
          <th style="width:140px;">Name</th>
          <th>Contact</th>
          <th style="width:300px;">Address</th>
          <th>License</th>
          <th>GST</th>
          <th>Goods</th>
          <th>Demand</th>
          <th>Rate</th>
          <th>Photo</th>
          <th style="width:200px;">Date</th>
          <th style="width:180px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td class="text-center"><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['type']) ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td>
              📞 <?= htmlspecialchars($row['mobile']) ?><br>
               <?= htmlspecialchars($row['email']) ?>
            </td>
            <td>
              <?= nl2br(htmlspecialchars($row['address'])) ?><br>
              <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['district_name'] ?? '') ?><br>
              <?= htmlspecialchars($row['state_name'] ?? '') ?> - <?= htmlspecialchars($row['pincode']) ?>
            </td>
            <td class="text-center">
              <span class="badge bg-<?= (isset($row['license_number']) && $row['license_number'] === 'YES') ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($row['license_number'] ?? '') ?>
              </span>
            </td>
            <td class="text-center">
              <span class="badge bg-<?= (isset($row['gst_number']) && $row['gst_number'] === 'YES') ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($row['gst_number'] ?? '') ?>
              </span>
            </td>
            <td><?= htmlspecialchars($row['goods_type']) ?></td>
            <td><?= htmlspecialchars($row['goods_demand']) ?></td>
            <td>₹<?= htmlspecialchars($row['sale_rate']) ?></td>
            <td>
              <?php if (!empty($row['photo']) && file_exists(__DIR__ . '/' . $row['photo'])): ?>
                <a href="<?= htmlspecialchars($row['photo']) ?>" target="_blank">
                  <img src="<?= htmlspecialchars($row['photo']) ?>" width="50" class="rounded shadow-sm" alt="photo">
                </a>
              <?php elseif (!empty($row['photo'])): ?>
                <a href="<?= htmlspecialchars($row['photo']) ?>" target="_blank">View</a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?= !empty($row['created_at']) ? date('d-m-Y H:i', strtotime($row['created_at'])) : '' ?></td>
            <td class="text-center">
              <a href="tender_update.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="tender_delete.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this tender?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'footer.php'; ?>
