<?php include 'header.php'; ?>

<style>
  body {
    background: url('assets/IMAGES/pxfuel.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .register-card {
    max-width: 700px;
    margin: 80px auto;
    background: rgba(255, 255, 255, 0.95); /* semi-transparent white */
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
  }
</style>

<div class="register-card">
  <h3 class="mb-4 text-center">Create Your Account</h3>

  <form action="register_action.php" method="post" enctype="multipart/form-data" class="row g-3">

    <!-- Name fields -->
    <div class="col-md-4">
      <label for="first_name" class="form-label">First Name *</label>
      <input type="text" name="first_name" id="first_name" class="form-control" required>
    </div>
    <div class="col-md-4">
      <label for="middle_name" class="form-label">Middle Name *</label>
      <input type="text" name="middle_name" id="middle_name" class="form-control" required>
    </div>
    <div class="col-md-4">
      <label for="last_name" class="form-label">Last Name *</label>
      <input type="text" name="last_name" id="last_name" class="form-control" required>
    </div>

    <!-- Contact -->
    <div class="col-md-6">
      <label for="mobile" class="form-label">Mobile *</label>
      <input type="text" name="mobile" id="mobile" class="form-control" pattern="\d{10}" placeholder="10 digits" required>
    </div>
    <div class="col-md-6">
      <label for="photo" class="form-label">Photo *</label>
      <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label for="email" class="form-label">Email *</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <!-- Password -->
    <div class="col-md-3">
      <label for="password" class="form-label">Password *</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label for="confirm_password" class="form-label">Confirm Password *</label>
      <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
    </div>

    <!-- Submit -->
    <div class="col-12 text-center mt-4">
      <button class="btn btn-primary px-5">Register</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>