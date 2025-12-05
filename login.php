<?php
session_start();
include 'header.php';
?>

<style>
  body {
    background: url('assets/IMAGES/pxfuel.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .login-card {
    max-width: 500px;
    margin: 80px auto;
    background: rgba(255, 255, 255, 0.9); /* semi-transparent white */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }
</style>

<div class="login-card">
  <h3 class="mb-4 text-center">Login to SETTribe</h3>

  <?php if(isset($_GET['msg'])): ?>
    <div class="alert alert-info text-center">
      <?= htmlspecialchars($_GET['msg']); ?>
    </div>
  <?php endif; ?>

  <form action="login_action.php" method="post" class="row g-3">
    <div class="col-12">
      <label for="email" class="form-label">Email *</label>
      <input type="email" name="email" id="email" class="form-control" required autocomplete="email">
    </div>

    <div class="col-12">
      <label for="password" class="form-label">Password *</label>
      <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="col-md-6">
      <label for="captcha" class="form-label">Captcha *</label>
      <input type="text" name="captcha" id="captcha" class="form-control" required>
    </div>

    <div class="col-md-6 d-flex align-items-end">
      <img src="captcha.php?x=<?= time(); ?>" alt="captcha" class="border rounded w-100">
    </div>

    <div class="col-12 mt-3">
      <button class="btn btn-primary w-100">Login</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>