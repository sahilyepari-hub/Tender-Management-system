<?php
require 'auth.php';
require 'db.php';

// Fetch tenders
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

<style>
/* Make Page Responsive */
body {
  background-size: cover;
  background-attachment: fixed;
}

/* Responsive container spacing */
@media (max-width: 576px) {
  .container {
    padding-left: 10px;
    padding-right: 10px;
  }
}

/* Responsive table wrapper */
.table-responsive {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 65vh;
  border: 1px solid #ddd;
  border-radius: 6px;
}

/* Optional: sticky header for better UX */
.table-responsive table thead th {
  position: sticky;
  top: 0;
  background: #343a40 !important;
  color: #fff;
  z-index: 5;
}

/* Mobile table font adjustments */
@media (max-width: 768px) {
  table.table {
    font-size: 12px;
  }
  table.table td, table.table th {
    padding: 6px;
  }
  .btn-sm {
    padding: 3px 6px;
    font-size: 11px;
  }
}

/* Make action buttons stack on smaller phones */
@media (max-width: 500px) {
  .action-buttons {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
}

/* Improve mobile readability */
td {
  vertical-align: middle !important;
}

/* Make images responsive inside table */
.table img {
  max-width: 45px;
  height: auto;
}
</style>

<div class="container mt-4">

  <h4 class="mb-3 text-center text-md-left">Submitted Tenders</h4>

  <?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
    <a href="tender_form.php" class="btn btn-success">➕ New Tender</a>
    <a href="export_excel.php" class="btn btn-info">Export to Excel</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-sm align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Type</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Address</th>
          <th>License</th>
          <th>GST</th>
          <th>Goods</th>
          <th>Demand</th>
          <th>Rate</th>
          <th>Photo</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td class="text-center"><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['type']) ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>

            <td>
              📞 <?= htmlspecialchars($row['mobile']) ?><br>
              <?= htmlspecialchars($row['email']) ?>
            </td>

            <td>
              <?= nl2br(htmlspecialchars($row['address'])) ?><br>
              <?= htmlspecialchars($row['city']) ?>,
              <?= htmlspecialchars($row['district_name'] ?? '') ?><br>
              <?= htmlspecialchars($row['state_name'] ?? '') ?> - <?= htmlspecialchars($row['pincode']) ?>
            </td>

            <td class="text-center">
              <span class="badge bg-<?= ($row['license_number'] === 'YES') ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($row['license_number']) ?>
              </span>
            </td>

            <td class="text-center">
              <span class="badge bg-<?= ($row['gst_number'] === 'YES') ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($row['gst_number']) ?>
              </span>
            </td>

            <td><?= htmlspecialchars($row['goods_type']) ?></td>
            <td><?= htmlspecialchars($row['goods_demand']) ?></td>
            <td>₹<?= htmlspecialchars($row['sale_rate']) ?></td>

            <td class="text-center">
              <?php if (!empty($row['photo']) && file_exists(__DIR__ . '/' . $row['photo'])): ?>
                <a href="<?= htmlspecialchars($row['photo']) ?>" target="_blank">
                  <img src="<?= htmlspecialchars($row['photo']) ?>" class="rounded shadow-sm">
                </a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>

            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>

            <td class="text-center action-buttons">
              <a href="tender_update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="tender_delete.php?id=<?= $row['id'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Delete this tender?')">Delete</a>
            </td>

          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'footer.php'; ?>
