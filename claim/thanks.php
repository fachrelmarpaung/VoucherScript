<?php 
session_start();
require_once('../function/function.php');
$load = new InputFront();
if(@$_POST['nohp']){
    ECHO @$_POST['nohp'];
}elseif($_POST){
    $error = "<span class='text-danger'><i class='ti ti-alert-circle'></i> Nomor anda telah terdaftar disistem kami!</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Voucher - PHD</title>
    <link rel="shortcut icon" type="image/png" href="https://www.pizzahut.co.id/favicon.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="dist/css/style.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body{
            background: transparent url('https://www.pizzahut.co.id/img/bg-app.67f30e52.jpg') 0 0;
        }
        .buttonme{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .top {
            background: #fff;
            box-shadow: rgba(0, 0, 0, 0.3) 0px 3px 5px 0px;
            padding: 10px;
            position: relative;
            z-index: 2;
        }
        .main {
            margin-top: -50px; /* Adjust this value as needed */
            margin-left: 16px;
            margin-right: 16px;
            display: flex;
            padding: 16px;
            flex-direction: column;
            align-items: center;
            border-radius: 16px;
            background: #FFFFFF;
            box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.08), 0px 1px 4px 0px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
        }
        @media screen and (max-width: 767px) {
            .main {
                margin-top: -7px; /* Adjusted margin for mobile devices */
            }
        }
        .main .logobanner{
            margin-top: -40px;
            background-color: #fff;
            padding: 10px;
            border-radius: 60px;
        }
        .title{
            text-align: center;
            font-size: 20px;
        }
    </style>
    <script src="dist/js/app-syn.js"></script>
</head>
<body>
    <header>
        <div class="top">
            <div class="container" style="background-color: #fff;">
                <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" alt="" width="150px">
            </div>
        </div>
    </header>
    <?php
    $imageSource = isMobile() ? "{$load->loadData()['Mobile']}" : "{$load->loadData()['Website']}";
    ?>
    <div class="banner">
        <img src="images/upload/<?= $imageSource; ?>" width="100%" alt="">
    </div>
    <div class="main">
        <div class="logobanner">
            <img src="https://upload.wikimedia.org/wikipedia/sco/thumb/d/d2/Pizza_Hut_logo.svg/1088px-Pizza_Hut_logo.svg.png" width="50px" alt="">
        </div>
        <div class="container">
            <div class="card-title title fw-semibold">
                Selamat Voucher anda berhasil di gunakan, selamat menikmati. 
                <div style="text-align: center;">
                    <img src="images/pizza.jpg" width="200px" alt="">
                </div>
            </div>
            <div class="text-center">
                <span class="fw-semibold">Silahkan masuk dan nikmati voucher lainnya di komunitas Pizza Hut Delivery Indonesia</span><br>
                <a class="btn btn-success font-medium rounded-pill px-4 mt-2" href="<?= $_SESSION['outletlink']; ?>">Join Komunitas <i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </div>
    
    <footer class="m-3">
        <div class="card-subtitle" style="font-size: 12px;">
            <table>
                <tr>
                    <td style="vertical-align:top;">
                        <span style="color:Red">*</span>
                    </td>
                    <td>
                        Syarat dan ketentuan berlaku.
                    </td>
                </tr>
            </table>
        </div>
    </footer>
</body>
</html>
<?php
// Function to detect if the user is on a mobile device
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>