<?php 
session_start();
require_once('../function/function.php');
$load = new InputFront();
if(@$_POST['phone_number']){
    $inputPhoneNumber = $_POST['phone_number'];
    $idoutlet = $_POST['idoutlet'];
    $claimInstance = new ClaimInstance($inputPhoneNumber,$idoutlet);
    $result = $claimInstance->inputdata();
    // Check the result and take appropriate actions
    if ($result === true) {
        header("Location: Voucher?outlet={$_SESSION['idoutlet']}");
        exit;
    } else {
        $error = "<span class='text-danger'><i class='ti ti-alert-circle'></i> Nomor anda telah terdaftar disistem kami!</span>";
    }
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
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
            font-size: 30px;
        }
        #button-background {
      position: relative;
      background-color: rgba(255, 255, 255, 0.3);
      width: 250px;
      height: 80px;
      border: white;
      border-radius: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #slider {
      transition: width 0.3s, border-radius 0.3s, height 0.3s;
      position: absolute;
      left: -14px;
      background-color: #e6fffa;
      width: 75px;
      height: 75px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #slider.unlocked {
      transition: all 0.3s;
      width: inherit;
      left: 0 !important;
      height: inherit;
      border-radius: inherit;
    }

    .material-icons {
      color: black;
      font-size: 50px;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      cursor: default;
    }

    .slide-text {
      color: #3a3d55;
      font-size: 22px;
      text-transform: uppercase;
      font-family: "Roboto", sans-serif;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      cursor: default;
    }
    @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
    @import url('https://fonts.googleapis.com/css?family=Roboto');

    #button-background {
    position: relative;
    background-color: rgb(255 255 255);
    width: 250px;
    height: 80px;
    border: white;
    border-radius: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center; /* Center horizontally */
    box-shadow: rgba(0, 0, 0, 0.3) 0px 3px 5px 0px;
    }

    #slider {
    transition: width 0.3s, border-radius 0.3s, height 0.3s;
    position: absolute;
    left: -14px;
    background-color: rgb(116 123 127);
    width: 75px;
    height: 75px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: #c5c5c5 0px 0px 7px 2px;
    }
    #slider.unlocked {
    transition: all 0.3s;
    width: inherit;
    left: 0 !important;
    height: inherit;
    border-radius: inherit;
    }

    .material-icons {
    color: rgb(255, 255, 255);
    font-size: 30px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: default;
    }

    .slide-text {
    color: #ffffff;
    font-size: 22px;
    text-transform: uppercase;
    font-family: "Roboto", sans-serif;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: default;
    }

    .bottom {
    position: fixed;
    bottom: 0;
    font-size: 14px;
    color: white;
    }
    .bottom a {
    color: white;
    }
    .description{
        max-width: 600px;
    }
    .image-wrapper {
    	border-radius: 6px;
    	background-color: #fff;
    	display: flex;
    	align-items: center;
    	text-align: center;
    	line-height: 1.6;
    
    	img {
    		height: auto;
    		max-width: 100%;
    	}
    }
    
    .shine {
    	position: relative;
    	overflow: hidden;
    
    	&::before {
    		background: linear-gradient(
    			to right,
    			fade_out(#fff, 1) 0%,
    			fade_out(#fff, 0.7) 100%
    		);
    		content: "";
    		display: block;
    		height: 100%;
    		left: -75%;
    		position: absolute;
    		top: 0;
    		transform: skewX(-25deg);
    		width: 50%;
    		z-index: 2;
    	}
    
    	&:hover,
    	&:focus {
    		&::before {
    			animation: shine 1.85s;
    		}
    	}
    
    	@keyframes shine {
    		100% {
    			left: 125%;
    		}
    	}
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
                 <?= $load->loadData()['Title']; ?>
            </div>
            <div class="mx-auto p-2 text-center">
                <img src="images/cupon.png" width="140px" alt="">
            </div>
            <div class="card-subtitle description mx-auto p-2">
                <div class="text-center fw-semibold mb-2">
                    Selamat bergabung di Komunitas Pizzahut Delivery, Silahkan nikmati voucher dan Promo-promo eksklusif lainnya di komuinitas Pizzahut Delivery
                </div>
                <div class="isi">
                    <?= $load->loadData()['Words']; ?>
                </div>
            </div>
            <form method="POST" id="myForm">
                <div class="input-group">
                    <button class="btn btn-light-info text-info font-medium" type="button">+62</button>
                    <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Example : 823XXXXXXXX" aria-label="Text input with radio button">
                    <input type="hidden" name="idoutlet" value="<?= $_SESSION['idoutlet']; ?>">
                </div>
                <?= isset($error) ? $error : ''; ?>
                <div class="buttonme">
                    <div id="button-background" style="margin-top: 30px;">
                        <div class="image-wrapper shine"><span class="slide-text"><img style="MARGIN-LEFT: 20PX;" src="images/ARROW.png" width="70%" alt=""></span></div>
                        <div id="slider">
                            <i id="locker" class="material-icons"><img src="images/pizza.png" width="80%" alt=""></i>
                        </div>
                    </div>
                </div>
            </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#phone_number').on('input', function() {
                let phoneNumber = $(this).val();
                let isPhone = /^([1-9][0-9]{8,11})$/.test(phoneNumber);
                let slider = $('#slider');

                // Change background color based on the disabled state
                slider.css('background-color', isPhone ? 'rgb(221, 26, 50)' : 'rgb(131, 131, 131)');

                // Import app-sync.js if the phone number is valid
                if (isPhone) {
                    $.getScript('dist/js/app-sync.js', function(data, textStatus, jqxhr) {
                        console.log('app-sync.js loaded successfully');
                    });
                }
            });
        });
        // Disable form submission on "Enter" key press
        document.getElementById("myForm").addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                return false;
            }
        });
    </script>


</body>
</html>
<?php
// Function to detect if the user is on a mobile device
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>