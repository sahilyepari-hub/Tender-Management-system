<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (isset($_SESSION['user_id'])) {
    header("Location: report.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TenderSphere</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
      body {
          background: url('images/background.jpg') no-repeat center center fixed;
          background-size: cover;
          min-height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 20px; /* prevents content touching screen edges */
      }

      .box {
          background: rgba(255,255,255,0.88);
          padding: 30px;
          border-radius: 12px;
          width: 100%;
          max-width: 420px;
          box-shadow: 0px 8px 25px rgba(0,0,0,0.25);
      }

      /* Responsive Typography */
      h2 {
          font-size: clamp(1.3rem, 2.3vw, 1.8rem); 
      }

      p {
          font-size: clamp(0.9rem, 1.8vw, 1rem);
      }

      /* Buttons responsive on mobile */
      @media (max-width: 576px) {
          .btn {
              width: 100%;
              padding: 12px;
          }

          .gap-3 {
              gap: 10px !important;
          }
      }
  </style>
</head>

<body>

<div class="box text-center">
    
    <h2 class="fw-bold mb-3">Welcome to TenderSphere</h2>
    <p class="text-muted mb-4">Please register or login to continue.</p>

    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
      <a href="register.php" class="btn btn-outline-primary px-4">Register</a>
      <a href="login.php" class="btn btn-primary px-4">Login</a>
    </div>

</div>

</body>
</html>
