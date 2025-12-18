<?php
session_start();

if (!empty($_POST)) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === "admin" && $password === "admin") {

    // set session login
    $_SESSION['login'] = true;
    $_SESSION['username'] = $username;

    header("Location: index.php");
    exit;
  } else {
    $error = "Username atau password salah";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Login</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom Style -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Roboto', sans-serif;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .login-box {
      background: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .login-title {
      font-weight: 700;
      text-align: center;
    }

    .login-subtitle {
      text-align: center;
      margin-bottom: 20px;
      color: #6c757d;
    }

    .custom-input {
      height: 45px;
      border-radius: 8px;
    }

    .custom-button {
      width: 100%;
      height: 45px;
      border-radius: 8px;
      font-weight: 600;
    }

    .logo-img {
      max-width: 75%;
      height: auto;
    }
  </style>
</head>

<body>

  <div class="login-wrapper">
    <div class="container">
      <div class="row align-items-center">

        <!-- LOGO -->
        <div class="col-md-6 text-center mb-4 mb-md-0">
          <img src="logo.jpg" alt="Logo" class="img-fluid logo-img">
        </div>

        <!-- LOGIN FORM -->
        <div class="col-md-6">
          <div class="login-box">

            <h1 class="login-title">LOGIN</h1>
            <p class="login-subtitle">DASHBOARD ADVENTURE WORK</p>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger text-center">
                <?= $error ?>
              </div>
            <?php endif; ?>

            <form method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input
                  type="text"
                  name="username"
                  class="form-control custom-input"
                  placeholder="Masukkan Username"
                  required>
              </div>

              <div class="mb-4">
                <label class="form-label">Password</label>
                <input
                  type="password"
                  name="password"
                  class="form-control custom-input"
                  placeholder="Masukkan Password"
                  required>
              </div>

              <button type="submit" class="btn btn-primary custom-button">
                Login
              </button>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>