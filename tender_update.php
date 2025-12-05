<?php
require 'auth.php';
require 'db.php';

$id = intval($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM tenders WHERE id=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$t = $res->fetch_assoc();
if (!$t) {
  header('Location: report.php?msg=Tender not found');
  exit;
}
?>
<?php include 'header.php'; ?>
<div class="container mt-4">
  <h4>Edit Tender #<?= $t['id'] ?></h4>
  <form action="tender_update_action.php" method="post">
    <input type="hidden" name="id" value="<?= $t['id'] ?>">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label"> Type *</label>
        <input type="text" name="type" class="form-control" required value="<?= htmlspecialchars($t['type']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Full Name *</label>
        <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($t['full_name']) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Mobile *</label>
        <input type="text" name="mobile" class="form-control" required value="<?= htmlspecialchars($t['mobile']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($t['email']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Goods Type *</label>
        <input type="text" name="goods_type" class="form-control" required value="<?= htmlspecialchars($t['goods_type']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Demand *</label>
        <input type="text" name="goods_demand" class="form-control" required value="<?= htmlspecialchars($t['goods_demand']) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Sale Rate *</label>
        <input type="text" name="sale_rate" class="form-control" required value="<?= htmlspecialchars($t['sale_rate']) ?>">
      </div>
      <div class="col-md-12">
        <label class="form-label">Remarks</label>
        <textarea name="remarks" class="form-control" rows="3"><?= htmlspecialchars($t['remarks']) ?></textarea>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary" type="submit">Update</button>
      <a class="btn btn-secondary" href="report.php">Cancel</a>
    </div>
  </form>
</div>
<?php include 'footer.php'; ?>