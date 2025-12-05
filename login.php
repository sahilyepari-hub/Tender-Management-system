<?php
session_start();
include 'header.php';
?>

<style>
  /* background */
  html, body {
    height: 100%;
  }
  body {
    background: url('assets/IMAGES/pxfuel.jpg') no-repeat center center fixed;
    background-size: cover;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  /* full-height wrapper to center the card */
  .page-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px; /* breathing room on small screens */
  }

  /* login card */
  .login-card {
    width: 100%;
    max-width: 520px;
    background: rgba(255, 255, 255, 0.92); /* slightly translucent for readability */
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.18);
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .login-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.20);
  }

  .login-card h3 {
    font-weight: 600;
    margin-bottom: 14px;
  }

  /* make inputs easier to tap on mobile */
  .login-card .form-control {
    padding: .56rem .7rem;
    border-radius: 8px;
  }

  /* captcha image responsive */
  .captcha-img {
    width: 100%;
    height: auto;
    object-fit: contain;
    border-radius: 6px;
    display: block;
  }

  /* small screens: stack fields and enlarge buttons */
  @media (max-width: 575.98px) {
    .login-card {
      padding: 18px;
      border-radius: 10px;
    }
    .login-card .btn {
      padding: 12px 14px;
      font-size: 1rem;
    }
  }

  /* medium screens: keep captcha reasonable */
  @media (min-width: 576px) and (max-width: 991.98px) {
    .captcha-img {
      max-height: 72px;
    }
  }

  /* Accessibility: focus ring */
  .form-control:focus, .btn:focus {
    outline: 3px solid rgba(0,123,255,0.12);
    outline-offset: 0px;
  }
</style>

<div class="page-wrap">
  <div class="login-card">
    <h3 class="text-center">Login to SETTribe</h3>

    <?php if(isset($_GET['msg'])): ?>
      <div class="alert alert-info text-center">
        <?= htmlspecialchars($_GET['msg']); ?>
      </div>
    <?php endif; ?>

    <form action="login_action.php" method="post" class="row g-3">
      <div class="col-12">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" required autocomplete="email" placeholder="you@example.com">
      </div>

      <div class="col-12">
        <label for="password" class="form-label">Password *</label>
        <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password" placeholder="Your password">
      </div>

      <div class="col-12 col-sm-6">
        <label for="captcha" class="form-label">Captcha *</label>
        <input type="text" name="captcha" id="captcha" class="form-control" required placeholder="Enter captcha">
      </div>

      <div class="col-12 col-sm-6 d-flex align-items-center">
        <!-- make captcha responsive and clickable to refresh -->
        <img src="captcha.php?x=<?= time(); ?>" alt="captcha" class="captcha-img border" id="captchaImg" title="Click to refresh captcha" style="cursor:pointer;">
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Click captcha to refresh
  document.addEventListener('DOMContentLoaded', function() {
    var img = document.getElementById('captchaImg');
    if (img) {
      img.addEventListener('click', function() {
        // append epoch to force reload
        this.src = 'captcha.php?x=' + Date.now();
      });
    }
  });
</script>

<?php include 'footer.php'; ?>
