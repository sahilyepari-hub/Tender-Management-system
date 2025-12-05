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
          height: 100vh;
      }

      .box {
          background: rgba(255,255,255,0.85);
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      }
  </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="box text-center" style="max-width: 400px; width: 100%;">
    
    <h2 class="mb-3 fw-bold">Welcome to TenderSphere</h2>
    <p class="text-muted mb-4">Please register or login to continue.</p>

    <div class="d-flex justify-content-center gap-3">
      <a href="register.php" class="btn btn-outline-primary px-4">Register</a>
      <a href="login.php" class="btn btn-primary px-4">Login</a>
    </div>

  </div>
</div>

</body>
</html>
