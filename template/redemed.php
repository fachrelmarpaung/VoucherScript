<?php 
session_start();
// if(empty($_SESSION['thanks'])){
//     header("Location: Welcome");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Diskon Tanpa Min. Pembelian</title>
    <link rel="shortcut icon" type="image/png" href="https://www.pizzahut.co.id/favicon.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @font-face {
            font-family: 'AvertaStdRegular';
            src: url("https://id-kk-web.oss-ap-southeast-5.aliyuncs.com/front_static/fonts/AvertaW01Regular.woff2") format("woff2"),url("https://id-kk-web.oss-ap-southeast-5.aliyuncs.com/front_static/fonts/AvertaW01Regular.woff") format("woff");
        }

        @font-face {
            font-family: 'AvertaStdBold';
            src: url("https://id-kk-web.oss-ap-southeast-5.aliyuncs.com/front_static/fonts/AvertaW01Bold.woff2") format("woff2"),url("https://id-kk-web.oss-ap-southeast-5.aliyuncs.com/front_static/fonts/AvertaW01Bold.woff") format("woff");
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            position: relative;
            font-weight: normal;
            font-family: 'AvertaStdRegular';
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        div {
            border: solid 0px green;
        }

        html {
            height: 100%;
            width: 100%;
            border: solid 0px #ccc;
        }

        body {
            height: 100%;
            width: 100%;
            border: solid 0px #999;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #F5EDE3;
        }

        .layout {
            height: 100%;
            width: 100%;
            border: solid 0px red;
            overflow: scroll;
        }

        .top {
            border: solid 0px green;
            width: 100%;
            height: 56px;
            overflow: hidden;
            background: #FFFFFF;
            padding-left: 1.5%;
            padding-right: 2.5%;
            display: flex;
            flex-direction: row;
            justify-items: center;
            align-items: center;
        }

        .top .logo {
            flex-grow: 0;
            width: 50px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .top .info {
            flex-grow: 1;
        }

        .top .info .title {
            font-weight: 700;
            font-size: 14px;
        }

        .top .info .sub-title {
            font-size: 12px;
            color: #828282;
        }

        .banner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4% 4% 0 4%;
        }

        .banner .logo {
            display: block;
        }

        .banner .picture {
            display: block;
        }

        .banner .picture img {
            display: block;
            width: 100%;
        }

        .main {
            margin-left: 16px;
            margin-right: 16px;
            display: flex;
            padding: 16px;
            flex-direction: column;
            align-items: center;
            border-radius: 16px;
            background: #FFFFFF;
            box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.08), 0px 1px 4px 0px rgba(0, 0, 0, 0.08);
        }

        .main .logo {
            width: 100%;
            text-align: center;
        }

        .main .logo img {
            width: 90px;
        }

        .main .title {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .main .title .title-text {
            width: 100%;
            font-style: normal;
            text-align: left;
            color: #222222;
            font-size: 16px;
            line-height: 22px;
            font-weight: 700;
            font-family: 'AvertaStdRegular';
        }

        .main .content {
            margin: 0 0 0 0;
            color: #222222;
        }

        .main .content p {
            margin: 16px 0 0 0;
            font-weight: 400;
            font-size: 14px;
            line-height: 18px;
        }

        .main .content p b {
            font-family: "AvertaStdBold";
        }

        .main .action {
            margin: 16px 0 0 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .main .action input {
            width: 100%;
            height: 48px;
            display: block;
            outline: none;
            background: #F2F2F2;
            border: 2px solid #F2F2F2;
            border-radius: 5px;
            align-items: flex-start;
            padding: 16px 12px 16px 60px;
            margin-bottom: 16px;
            font-size: 16px;
            line-height: 20px;
        }

        .main .action .phone-hint {
            position: absolute;
            left: 0;
            top: 0;
            height: 48px;
            padding: 14px 12px;
            font-size: 16px;
            line-height: 20px;
        }

        .main .action button {
            width: 100%;
            height: 48px;
            background: #25D366;
            border: solid 0 gray;
            border-radius: 5px;
            font-style: normal;
            font-weight: 700;
            font-size: 16px;
            line-height: 20px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "AvertaStdRegular";
        }

        .main .action button svg {
            margin-left: 10px;
        }

        .main .separator {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin: 16px 16px;
        }

        .main .separator hr {
            /*border: 5px solid red;*/
            height: 0.4px;
            width: 40%;
        }

        .main .separator .separator-text {
            font-size: 14px;
        }

        .footer {
            padding-bottom: 30px;
        }

        .footer .info {
            margin: 16px 16px 0 16px ;
        }

        .footer .info p {
            font-size: 10px;
            line-height: 12px;
            color: #222222;
        }

        .footer .separator {
            margin: 0 0 0 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }

        .footer .separator img {
            height: 64px;
        }

        .footer .comment {
            text-align: center;
            font-style: normal;
            font-weight: 400;
            font-size: 10px;
            line-height: 12px;
            color: #4F4F4F;
        }
        .logobanner{
            background-color: #fff;
            padding: 10px;
            border-radius: 60px;
            margin-top: -50px;
        }

        .top img {
            width: 150px;
        }

        /* Additional style for logobanner */
        .logobanner {
            background-color: #fff;
            padding: 10px;
            border-radius: 60px;
            margin-top: -50px;
        }
        .success{
            margin-top: 20px;
            width: 100%;
            background-color: #25D366;
            padding:10px;
            border-radius: 5px;
            text-decoration: none;
            color:white;
            font-size: 19px;
            font-weight: 700px;
        }
        footer{
            padding: 20px ;
        }
        .info{
            font-weight: 700;
            font-size: 12px;
            color: #828282;
        }
        .btn{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <div class="top">
            <img src="https://www.pizzahut.co.id/img/logo-phd2.1e64ffda.png" alt="" width="150px">
        </div>
    </header>
    <div class="banner">
        <div class="picture">
            <img src="images/slice.png" alt="">
        </div>
    </div>
    <div class="main">
        <div class="logobanner">
            <img src="https://upload.wikimedia.org/wikipedia/sco/thumb/d/d2/Pizza_Hut_logo.svg/1088px-Pizza_Hut_logo.svg.png" width="50px" alt="">
        </div>
        <div class="title">
            <span style="font-weight: 700;">Berhasil</span>
        </div>
        <div class="action" style="max-width: 600px; text-align: center;">
            Selamat Voucher anda berhasil di gunakan, selamat menikmati.
            <div style="text-align: center;">
                <img src="images/pizza.jpg" width="300px" alt="">
            </div>
        </div>
    </div>
    <footer>
        <div class="info">
            <p>Setelah join Komunitas WhatsApp Pizzahut Delivery, kami akan mengirimkan voucher ke nomor kamu.<br>Proses ini memerlukan beberapa jam karena tingginya antusiasme.<br>Kamu akan menerima notifikasi melalui WhatsApp dari nomor resmi "Pizzahut Delivery Loyalty" saat voucher berhasil terkirim.</p>
        </div>
    </footer>
</body>
</html>
