<?php include 'header.php'; ?>

<style>
  html, body { height: 100%; }

  body {
    background: url('assets/IMAGES/pxfuel.jpg') no-repeat center center fixed;
    background-size: cover;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  .page-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .register-card {
    width: 100%;
    max-width: 900px;           /* limit width on large screens */
    background: rgba(255, 255, 255, 0.95);
    padding: 28px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.18);
  }

  .register-card h3 {
    font-weight: 600;
    margin-bottom: 14px;
    text-align: center;
  }

  /* Make inputs larger & easier to tap on small screens */
  .register-card .form-control {
    padding: .56rem .7rem;
    border-radius: 8px;
  }

  /* File input full width & keep label readable */
  .form-label { font-size: .95rem; }

  /* Responsive tweaks */
  @media (max-width: 575.98px) {
    .register-card {
      padding: 18px;
      margin: 10px;
    }
    .register-card .btn {
      padding: 12px 14px;
      font-size: 1rem;
      width: 100%;
    }
  }

  @media (min-width: 576px) and (max-width: 991.98px) {
    .register-card { padding: 22px; }
  }

  /* Accessibility focus */
  .form-control:focus, .btn:focus {
    outline: 3px solid rgba(0,123,255,0.12);
    outline-offset: 0;
  }

  /* Optional visual hint for mismatch */
  .pw-mismatch { color: #d9534f; font-size: .9rem; display: none; margin-top: .25rem; }
</style>

<div class="page-wrap">
  <div class="register-card">
    <h3>Create Your Account</h3>

    <form action="register_action.php" method="post" enctype="multipart/form-data" class="row g-3" id="registerForm" novalidate>

      <!-- Name fields: stack on small screens, 3 columns on md+ -->
      <div class="col-12 col-md-4">
        <label for="first_name" class="form-label">First Name *</label>
        <input type="text" name="first_name" id="first_name" class="form-control" required>
        <div class="invalid-feedback">First name is required.</div>
      </div>

      <div class="col-12 col-md-4">
        <label for="middle_name" class="form-label">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name" class="form-control">
      </div>

      <div class="col-12 col-md-4">
        <label for="last_name" class="form-label">Last Name *</label>
        <input type="text" name="last_name" id="last_name" class="form-control" required>
        <div class="invalid-feedback">Last name is required.</div>
      </div>

      <!-- Contact -->
      <div class="col-12 col-md-6">
        <label for="mobile" class="form-label">Mobile *</label>
        <input type="tel" name="mobile" id="mobile" class="form-control" pattern="[6-9][0-9]{9}" placeholder="10 digits" required>
        <div class="invalid-feedback">Enter a valid 10-digit mobile number starting with 6-9.</div>
      </div>

      <div class="col-12 col-md-6">
        <label for="photo" class="form-label">Photo *</label>
        <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="form-control" required>
        <div class="invalid-feedback">Please upload a photo (jpg/png).</div>
      </div>

      <div class="col-12 col-md-6">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <div class="invalid-feedback">Please provide a valid email.</div>
      </div>

      <!-- Passwords -->
      <div class="col-12 col-md-3">
        <label for="password" class="form-label">Password *</label>
        <input type="password" name="password" id="password" class="form-control" minlength="6" required>
        <div class="invalid-feedback">Password (min 6 characters) required.</div>
      </div>

      <div class="col-12 col-md-3">
        <label for="confirm_password" class="form-label">Confirm Password *</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" minlength="6" required>
        <div class="invalid-feedback">Please confirm your password.</div>
        <div class="pw-mismatch" id="pwMismatch">Passwords do not match.</div>
      </div>

      <!-- Submit -->
      <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary px-5" id="submitBtn">Register</button>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
  // Client-side validation + password match
  (function() {
    const form = document.getElementById('registerForm');
    const pwd = document.getElementById('password');
    const cpwd = document.getElementById('confirm_password');
    const mismatch = document.getElementById('pwMismatch');

    function checkPasswords() {
      if (!pwd.value && !cpwd.value) {
        mismatch.style.display = 'none';
        cpwd.classList.remove('is-invalid');
        return true;
      }
      if (pwd.value !== cpwd.value) {
        mismatch.style.display = 'block';
        cpwd.classList.add('is-invalid');
        return false;
      } else {
        mismatch.style.display = 'none';
        cpwd.classList.remove('is-invalid');
        cpwd.classList.add('is-valid');
        return true;
      }
    }

    cpwd.addEventListener('input', checkPasswords);
    pwd.addEventListener('input', checkPasswords);

    form.addEventListener('submit', function(e) {
      // let browser native validity check first
      if (!form.checkValidity() || !checkPasswords()) {
        e.preventDefault();
        e.stopPropagation();
        // show bootstrap invalid feedback
        form.classList.add('was-validated');
        return false;
      }
      // form is valid — submit normally
    }, false);
  })();
</script>
