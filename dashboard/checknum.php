<?php 
session_start();
require_once("../function/function.php");
$homeInstance = new Home();
$outletInfo = new Viewnumber();
$LoadNumber = $outletInfo->ListNumberbyId("{$_GET['outlet']}");
if(empty($_SESSION['user'])){
    header('Location: ../administrator');
}
if (empty(@$_GET['p'])) {
    echo "<script>window.location.replace('?page=barang&p=1');</script>";
}elseif(@$_GET['search']){
    $LoadNumber = $outletInfo->cariNumber($_GET['search'],$_GET['outlet']);
}if (isset($_POST['find'])) {
    if ($outletInfo->carikan($_POST['search']) > 0) {
        echo "<script>alert('Berhasil Menginput Data');</script>";
    } else {
        echo mysqli_error($conn);
    }
}
if(isset($_POST['delete'])){
  $phonenum = $_POST['phonenum'];
  $redirect = "?success";
  $outletHandler = new Phonebook();
  $result = $outletHandler->deletePhoneNumber($phonenum, $redirect); 
}

if(isset($_POST['export'])){
  $exporter = new ExcelExporter();
  $exporter->exportToExcelOutlet();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!--  Title -->
    <title>PHD KOMUNITAS</title>
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
    <link  id="themeColors"  rel="stylesheet" href="../dist/css/style.min.css" />
  </head>
  <body>
    <!-- Preloader -->
    <div class="preloader">
      <img src="../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <img src="../dist/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
           <a href="./index.html" class="text-nowrap logo-img">
              <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" class="dark-logo" width="180" alt="" />
              <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" class="light-logo"  width="180" alt="" />
  </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Home -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              <li class="sidebar-item">
                <a class="sidebar-link" href="dashboard" aria-expanded="false">
                  <span>
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Home</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="Admins" aria-expanded="false">
                  <span>
                    <i class="ti ti-users"></i>
                  </span>
                  <span class="hide-menu">Admin</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="Phonenumber" aria-expanded="false">
                  <span>
                    <i class="ti ti-user-star"></i>
                  </span>
                  <span class="hide-menu">Phone Number</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="Landing" aria-expanded="false">
                  <span>
                    <i class="ti ti-building-store"></i>
                  </span>
                  <span class="hide-menu">Landing Page</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="Outlet" aria-expanded="false">
                  <span>
                    <i class="ti ti-cpu"></i>
                  </span>
                  <span class="hide-menu">Outlet</span>
                </a>
              </li>
          </nav>
          <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
              <div class="john-img">
                <img src="../dist/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="">
              </div>
              <div class="john-title">
                <h6 class="mb-0 fs-4 fw-semibold"><?= $_SESSION['user']['username']; ?></h6>
                <span class="fs-2 text-dark"><?= $_SESSION['user']['Fullname']; ?></span>
              </div>
              <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                <i class="ti ti-power fs-6"></i>
              </button>
            </div>
          </div>  
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!-- Sidebar End -->
      <!-- Main wrapper -->
      <div class="body-wrapper">
        <!-- Header Start -->
        <header class="app-header"> 
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
            </ul>
            <div class="d-block d-lg-none">
              <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" class="dark-logo" width="180" alt="" />
              <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" class="light-logo"  width="180" alt="" />
            </div>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <div class="d-flex align-items-center justify-content-between">
                <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                  <i class="ti ti-align-justified fs-7"></i>
                </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="../dist/images/profile/user-1.jpg" class="rounded-circle" width="35" height="35" alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="../dist/images/profile/user-1.jpg" class="rounded-circle" width="80" height="80" alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3"><?= $_SESSION['user']['Fullname']; ?></h5>
                            <span class="mb-1 d-block text-dark"><?= $_SESSION['user']['username']; ?></span>
                          </div>
                        </div>
                        <div class="message-body">
                          <a href="MyProfile" class="py-8 px-7 mt-8 d-flex align-items-center">
                            <span class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                              <img src="../dist/images/svgs/icon-account.svg" alt="" width="24" height="24">
                            </span>
                            <div class="w-75 d-inline-block v-middle ps-3">
                              <h6 class="mb-1 bg-hover-primary fw-semibold"> My Profile </h6>
                              <span class="d-block text-dark">Account Settings</span>
                            </div>
                          </a>
                        </div>
                        <div class="d-grid py-4 px-7 pt-8">
                          <a href="./authentication-login.html" class="btn btn-outline-primary">Log Out</a>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <!-- Header End -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="d-flex align-items-center gap-4 mb-4">
                <div class="position-relative">
                  <div class="border border-2 border-primary rounded-circle">
                    <img src="../dist/images/profile/user-1.jpg" class="rounded-circle m-1" alt="user1" width="60" />
                  </div>
                  </span>
                </div>
                <div>
                  <h3 class="fw-semibold">Hi, <span class="text-dark"><?= $_SESSION['user']['Fullname']; ?></span>
                  </h3>
                  <span>Cheers, and happy activities - <?= date(" j F Y"); ?></span>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center mb-9">
                    <div>
                      <h5 class="card-title fw-semibold">Total User <?= $outletInfo->viewOutlet($_GET['outlet'])['outlatename']; ?></h5>
                      <p class="card-subtitle">Total Users Peroutlet</p>
                    </div>
                    <div class="ms-auto">
                        <form method="POST">
                            <table>
                            <tr>
                                <td><input type="text" class="form-control" name="search" placeholder="Cari Nomor..." style="border-bottom-right-radius: 0;border-top-right-radius: 0;"></td>
                                <td><button class="btn btn-primary" type="submit" name="find" style="border-bottom-left-radius: 0;border-top-left-radius: 0;"><i class="ti ti-search"></i></button></td>
                            </tr>
                            </table>
                        </form>
                        <form method="post" class="mt-2">
                            <input type="hidden" name="outlet" value="<?= $_GET['outlet']; ?>">
                            <button class="btn btn-primary" type="submit" name="export"><i class="ti ti-database-export"></i> Export to Excel</button>
                        </form>
                    </div>
                  </div>
                  <!-- Tab panes -->
                  <div class="tab-content mt-3">
                    <div class="tab-pane active" id="home" role="tabpanel">
                      <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                          <tbody>
                            <tr>
                              <td class="ps-0">
                                <div class="d-flex align-items-center gap-3">
                                  <div>
                                    <h6 class="mb-0 fw-semibold">No</h6>
                                  </div>
                                </div>
                              </td>
                              <td class="ps-0">
                                <div class="d-flex align-items-center gap-3">
                                  <div>
                                    <h6 class="mb-0 fw-semibold">Phone Number</h6>
                                  </div>
                                </div>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0">Kode Outlet</h6>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0">Date <?php 
                                if(isset($_GET['short'])){
                                  ?>
                                    <a href="?outlet=<?=$_GET['outlet'];?>&p=<?=$_GET['p'];?>"><i class="ti ti-chevron-up text-muted ms-1 fs-4"></i></a>
                                  <?php
                                }else{
                                  ?>
                                  <a href="?outlet=<?=$_GET['outlet'];?>&p=<?=$_GET['p'];?>&short=asc"><i class="ti ti-chevron-down text-muted ms-1 fs-4"></i></a>
                                <?php
                                }
                                 ?></h6>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0">Action</h6>
                              </td>
                            </tr>
                            <?php
                            if ($LoadNumber !== false) {
                                if ($LoadNumber->num_rows > 0) {
                                    $i = 1;
                                    $s = (($_GET['p'] * 10) - 10);
                                    while ($Number = $LoadNumber->fetch_assoc()) {

                            ?>
                            <tr>
                              <td class="ps-0">
                                <div class="d-flex align-items-center gap-3">
                                  <div>
                                    <h6 class="mb-0 fw-semibold"><?= $i++; ?></h6>
                                  </div>
                                </div>
                              </td>
                              <td class="ps-0">
                                <div class="d-flex align-items-center gap-3">
                                  <div>
                                    <h6 class="mb-0 fw-semibold"><span class="badge text-bg-success rounded">+62</span><?= $Number['phonenumber']; ?></h6>
                                  </div>
                                </div>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0"><?= $Number['idoutlet']; ?></h6>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0"><?= $Number['date']; ?></h6>
                              </td>
                              <td class="ps-0">
                                <h6 class="mb-0">
                                  <form method="post">
                                    <input type="hidden" name="phonenum" value="<?= $Number['phonenumber']; ?>">
                                    <button type="submit" name="delete" class="btn btn-light-danger text-danger font-medium">Delete</button>
                                  </form>
                                </h6>
                              </td>
                            </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="11" class="col-auto" align="center"> No Data </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="col-auto" align="center"> Unable To check the table </td>
                        </tr>
                    <?php
                    } ?>
                          </tbody>
                        </table>
                        <nav aria-label="Page navigation" style="float:right" class="mt-2">
                            <ul class="pagination pagination-primary">
                                <?php
                                if(empty($_GET['search'])){
                                    if ($GLOBALS['jmlhhalaman'] > 1) {
                                    if ($_GET['p'] > 1) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Prev</a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 1); ?></a></li>
                                    <?PHP } elseif ($_GET['p'] > 2) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Prev</a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] - 2); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 2); ?></a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 1); ?></a></li>
                                    <?PHP } ?>
                                    <li class="page-item active"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= $_GET['p']; ?>"><?= $_GET['p']; ?></a></li>
                                    <?php if ($_GET['p'] < ($GLOBALS['jmlhhalaman'] - 1)) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 1); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] + 2); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 2); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Next</a></li>
                                    <?PHP } elseif ($_GET['p'] < $GLOBALS['jmlhhalaman']) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 1); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Next</a></li>
                                <?PHP } } } else {
                                if ($GLOBALS['jmlhhalaman'] > 1) {
                                    if ($_GET['p'] > 1) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Prev</a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 1); ?></a></li>
                                    <?PHP } elseif ($_GET['p'] > 2) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Prev</a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] - 2); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 2); ?></a></li>
                                        <li class="page-item "><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] - 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] - 1); ?></a></li>
                                    <?PHP } ?>
                                    <li class="page-item active"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= $_GET['p']; ?>"><?= $_GET['p']; ?></a></li>
                                    <?php if ($_GET['p'] < ($GLOBALS['jmlhhalaman'] - 1)) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 1); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] + 2); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 2); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Next</a></li>
                                    <?PHP } elseif ($_GET['p'] < $GLOBALS['jmlhhalaman']) { ?>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>"><?= ($_GET['p'] + 1); ?></a></li>
                                        <li class="page-item"><a class="page-link" href="?outlet=<?= $_GET['outlet'];?>&search=<?= $_GET['search']?>&p=<?= ($_GET['p'] + 1); ?><?php if(isset($_GET['short'])){echo"&short=ASC";}?>">Next</a></li>
                                <?php } } } ?>
                            </ul>
                        </nav>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- container-fluid over -->
        </div>
      </div>
    </div>
    <!-- Customizer -->
   <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <i class="ti ti-settings fs-7" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"></i>
  </button>
  <div class="offcanvas offcanvas-end customizer" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" data-simplebar="">
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
      <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">Settings</h4>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
      <div class="theme-option pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Theme Option</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a href="javascript:void(0)"  onclick="toggleTheme('../dist/css/style.min.css')"  class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 light-theme text-dark">
            <i class="ti ti-brightness-up fs-7 text-primary"></i>
            <span class="text-dark">Light</span>
          </a>
          <a href="javascript:void(0)" onclick="toggleTheme('../dist/css/style-dark.min.css')" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 dark-theme text-dark">
            <i class="ti ti-moon fs-7 "></i>
            <span class="text-dark">Dark</span>
          </a>
        </div>
      </div>
      <div class="theme-direction pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Theme Direction</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a href="./index.html" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2">
            <i class="ti ti-text-direction-ltr fs-6 text-primary"></i>
            <span class="text-dark">LTR</span>
          </a>
          <a href="../rtl/index.html" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2">
            <i class="ti ti-text-direction-rtl fs-6 text-dark"></i>
            <span class="text-dark">RTL</span>
          </a>
        </div>
      </div>
      <div class="theme-colors pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Theme Colors</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <ul class="list-unstyled mb-0 d-flex gap-3 flex-wrap change-colors">
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)" class="rounded-circle position-relative d-block customizer-bgcolor skin1-bluetheme-primary active-theme " onclick="toggleTheme('../dist/css/style.min.css')"  data-color="blue_theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="BLUE_THEME"><i class="ti ti-check text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)"  class="rounded-circle position-relative d-block customizer-bgcolor skin2-aquatheme-primary " onclick="toggleTheme('../dist/css/style-aqua.min.css')"  data-color="aqua_theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="AQUA_THEME"><i class="ti ti-check  text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)" class="rounded-circle position-relative d-block customizer-bgcolor skin3-purpletheme-primary" onclick="toggleTheme('../dist/css/style-purple.min.css')"  data-color="purple_theme" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PURPLE_THEME"><i class="ti ti-check  text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)" class="rounded-circle position-relative d-block customizer-bgcolor skin4-greentheme-primary" onclick="toggleTheme('../dist/css/style-green.min.css')"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="GREEN_THEME"><i class="ti ti-check  text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)" class="rounded-circle position-relative d-block customizer-bgcolor skin5-cyantheme-primary" onclick="toggleTheme('../dist/css/style-cyan.min.css')"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="CYAN_THEME"><i class="ti ti-check  text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
            <li class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center justify-content-center">
              <a href="javascript:void(0)" class="rounded-circle position-relative d-block customizer-bgcolor skin6-orangetheme-primary" onclick="toggleTheme('../dist/css/style-orange.min.css')"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME"><i class="ti ti-check  text-white d-flex align-items-center justify-content-center fs-5"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="layout-type pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Layout Type</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a href="./index.html" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2">              
            <i class="ti ti-layout-sidebar fs-6 text-primary"></i>
            <span class="text-dark">Vertical</span>
          </a>
          <a href="../horizontal/index.html" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2">
            <i class="ti ti-layout-navbar fs-6 text-dark"></i>
            <span class="text-dark">Horizontal</span>
          </a>
        </div>
      </div>
      <div class="container-option pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Container Option</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 boxed-width text-dark">              
            <i class="ti ti-layout-distribute-vertical fs-7 text-primary"></i>
            <span class="text-dark">Boxed</span>
          </a>
          <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 full-width text-dark">
            <i class="ti ti-layout-distribute-horizontal fs-7"></i>
            <span class="text-dark">Full</span>
          </a>
        </div>
      </div>
      <div class="sidebar-type pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Sidebar Type</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a  href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 fullsidebar">              
            <i class="ti ti-layout-sidebar-right fs-7"></i>
            <span class="text-dark">Full</span>
          </a>
          <a  href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center text-dark sidebartoggler gap-2">
            <i class="ti ti-layout-sidebar fs-7"></i>
            <span class="text-dark">Collapse</span>
          </a>
        </div>
      </div>
      <div class="card-with pb-4">
        <h6 class="fw-semibold fs-4 mb-1">Card With</h6>
        <div class="d-flex align-items-center gap-3 my-3">
          <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 text-dark cardborder">              
            <i class="ti ti-border-outer fs-7"></i>
            <span class="text-dark">Border</span>
          </a>
          <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 cardshadow">
            <i class="ti ti-border-none fs-7"></i>
            <span class="text-dark">Shadow</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- ---------------------------------------------- -->
  <!-- Customizer -->
  <!-- ---------------------------------------------- -->
  <!-- ---------------------------------------------- -->
  <!-- Import Js Files -->
  <!-- ---------------------------------------------- -->
  <script src="../dist/libs/jquery/dist/jquery.min.js"></script>
  <script src="../dist/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="../dist/js/app.min.js"></script>
  <script src="../dist/js/app.init.js"></script>
  <script src="../dist/js/app-style-switcher.js"></script>
  <script src="../dist/js/sidebarmenu.js"></script>
  
  <script src="../dist/js/custom.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->
  <script src="../dist/js/apps/chat.js"></script>
  </body>
</html>