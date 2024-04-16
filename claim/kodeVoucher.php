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

<?php
// Function to detect if the user is on a mobile device
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
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
    <link rel="stylesheet" href="dist/css/numpad.css">
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
            font-size: 30px;
        }
        .pin-login {
    display: inline-block;
    border-radius: 10px;
    padding: 10px;
    font-size: 28px;
    background: #d9deff;
    border: 1px solid #363b5e;
    user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -webkit-user-select: none;
    font-family: sans-serif;
  }
  
  .pin-login__text {
    margin: 10px auto 10px auto;
    padding: 10px;
    display: block;
    width: 50%;
    font-size: 0.5em;
    text-align: center;
    letter-spacing: 0.2em;
    background: rgba(0, 0, 0, 0.15);
    border: none;
    border-radius: 10px;
    outline: none;
    cursor: default;
  }
  
  .pin-login__text--error {
    color: #901818;
    background: #ffb3b3;
    animation-name: loginError;
    animation-duration: 0.1s;
    animation-iteration-count: 2;
  }
  
  @keyframes loginError {
    25% {
      transform: translateX(-3px);
    }
    75% {
      transform: translateX(3px);
    }
  }
  
  @-moz-keyframes loginError {
    25% {
      transform: translateX(-3px);
    }
    75% {
      transform: translateX(3px);
    }
  }
  
  .pin-login__key {
    width: 60px;
    height: 60px;
    margin: 10px;
    background: rgba(0, 0, 0, 0.15);
    color: #363b5e;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
  }
  
  .pin-login__key:active {
    background: rgba(0, 0, 0, 0.25);
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
                Tunjukkan ke kasir untuk mengisi password code
            </div>
            <form method="POST">
                <div class="mx-auto p-2 text-center">
                <div class="pin-login" id="mainPinLogin">
                    <input type="password" readonly class="pin-login__text">
                    <div class="pin-login__numpad">
                        <!-- <div class="pin-login__key">0</div>
                        <div class="pin-login__key">0</div> -->
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
    <script>
        class PinLogin {
    constructor ({el, loginEndpoint, redirectTo, maxNumbers = Infinity}) {
        this.el = {
            main: el,
            numPad: el.querySelector(".pin-login__numpad"),
            textDisplay: el.querySelector(".pin-login__text")
        };

        this.loginEndpoint = loginEndpoint;
        this.redirectTo = redirectTo;
        this.maxNumbers = maxNumbers;
        this.value = "";

        this._generatePad();
    }

    _generatePad() {
        const padLayout = [
            "1", "2", "3",
            "4", "5", "6",
            "7", "8", "9",
            "backspace", "0", "done"
        ];

        padLayout.forEach(key => {
            const insertBreak = key.search(/[369]/) !== -1;
            const keyEl = document.createElement("div");

            keyEl.classList.add("pin-login__key");
            keyEl.classList.toggle("material-icons", isNaN(key));
            keyEl.textContent = key;
            keyEl.addEventListener("click", () => { this._handleKeyPress(key) });
            this.el.numPad.appendChild(keyEl);

            if (insertBreak) {
                this.el.numPad.appendChild(document.createElement("br"));
            }
        });
    }

    _handleKeyPress(key) {
        switch (key) {
            case "backspace":
                this.value = this.value.substring(0, this.value.length - 1);
                break;
            case "done":
                this._attemptLogin();
                break;
            default:
                if (this.value.length < this.maxNumbers && !isNaN(key)) {
                    this.value += key;
                }
                break;
        }

        this._updateValueText();
    }

    _updateValueText() {
        this.el.textDisplay.value = "_".repeat(this.value.length);
        this.el.textDisplay.classList.remove("pin-login__text--error");
    }

    _attemptLogin() {
    if (this.value.length > 0) {
        const outletParam = new URLSearchParams(window.location.search).get('outlet');

        fetch(this.loginEndpoint, {
            method: "post",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `pincode=${this.value}&outlet=${outletParam}`
        }).then(response => {
            if (response.status === 200) {
                window.location.href = this.redirectTo;
            } else {
                this.el.textDisplay.classList.add("pin-login__text--error");
            }
        })
    }
}
}

new PinLogin({
    el: document.getElementById("mainPinLogin"),
    loginEndpoint: "claim/login.php",
    redirectTo: "Thanks?outlet=P195"
});
    </script>
</body>
</html>