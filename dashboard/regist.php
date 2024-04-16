<?php 
require_once('../function/function.php');
if (isset($_POST['register'])) {
    // Retrieve form data
    $fullname = $_POST["FullName"];
    $username = $_POST["Username"];
    $_SESSION['fullname'] = $_POST["FullName"];
    $_SESSION['Username'] = $_POST["Username"];
    $password = $_POST["Password"];
    $passwordConfirmation = $_POST["PasswordConfirmation"];
    $registerInstance = new Register($fullname, $username, $password, $passwordConfirmation);
    if ($registerInstance->registerUser()> 0) {
        echo "<script>alert('Berhasil Menginput Data');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!--  Title -->
    <title>PHD Komunitas</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="https://www.pizzahut.co.id/favicon.png" />
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="dist/css/style.min.css" />
  </head>
  <body>
    <!-- Preloader -->
    <div class="preloader">
      <img src="dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0">
                <div class="card-body">
                  <a href="./index.html" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                    <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" width="180" alt="">
                  </a>
                  <form method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Full Name</label>
                      <input type="text" name="FullName" class="form-control" <?php echo isset($_SESSION['fullname']) ? "value='{$_SESSION["fullname"]}'" : ''; ?> id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Username</label>
                      <input type="text" name="Username" <?php echo isset($_SESSION['Username']) ? "value='{$_SESSION["Username"]}'" : ''; ?> class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                      <?php 
                      if(@$registerInstance->response['errors']['Username']){
                        echo "<div class='mt-1 badge w-100 bg-light-danger text-danger' style='text-align:left;'><i class='ti ti-alert-circle'></i> {$registerInstance->response['errors']['Username']}</div>";
                      }
                      ?>
                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" name="Password" class="form-control" id="exampleInputPassword1" required>
                    </div>
                    <div class="mb-4">
                      <label for="exampleInputPassword1" class="form-label">Password Confirmation</label>
                      <input type="password" name="PasswordConfirmation" class="form-control" id="exampleInputPassword1" required>
                      <?php 
                      if(@$registerInstance->response['errors']['Password_confirmation']){
                        echo "<div class='mt-1 badge w-100 bg-light-danger text-danger' style='text-align:left;'><i class='ti ti-alert-circle'></i> {$registerInstance->response['errors']['Password_confirmation']}</div>";
                      }
                      ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <a class="text-primary fw-medium" href="./authentication-forgot-password.html">Forgot Password ?</a>
                    </div>
                    <button class="btn btn-primary w-100 py-8 mb-4 rounded-2" name="register">Sign-up</button>
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-medium">New to PHD Komunitas?</p>
                      <a class="text-primary fw-medium ms-2" href="administrator">Sign-in</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!--  Import Js Files -->
    <script src="dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--  core files -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/app.init.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    
    <script src="dist/js/custom.js"></script>
  </body>
</html>