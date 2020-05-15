<?php
namespace app\index\controller;

use Knp\Snappy\Image;

class Test
{
    public function index()
    {
        require __DIR__ . '/../../../vendor/autoload.php';

        // 首先实例类，根据系统不同，选择不一样的脚本程序
        $imageSnappy = new Image(__DIR__ . '/../../../vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64');

        // 如果有中文的话，需要添加中文字体
        $ttf = __DIR__ . '/../../../public/static/sc.ttf';
        // 需要合成的图片地址，base64也可以的，其实跟这个也无关，主要是html能静态展示，那么合成的就是什么样的
        $name = '扑你阿木';

// html代码，随意搞了搞，真实使用的话，需要用心调整样式哦~
//        $htmlTemplate = <<<EOF
//<!DOCTYPE html>
//<!DOCTYPE html>
//<html lang="en">
//<head>
//    <meta charset="UTF-8">
//    <meta name="viewport" content="width=device-width, initial-scale=1.0">
//    <meta http-equiv="X-UA-Compatible" content="ie=edge">
//    <title>海报</title>
//</head>
//<style>
//    @font-face {
//        font-family: myFirstFont;
//        src: url('{$ttf}');
//    }
//
//    body {
//        font-family: myFirstFont;
//        text-align: center;
//        padding: 100px;
//        background: #8B91A0;
//    }
//
//    .image {
//        width: 300px;
//        height: 300px;
//        position: relative;
//    }
//
//    .content {
//        background: white;
//        width: 300px;
//        position: absolute;
//        top: 380px;
//        left: 520px;
//    }
//</style>
//<body>
//<img src="https://owohac-oss.oss-cn-shenzhen.aliyuncs.com/adopt/admin_web/202005/08/8e64d2139b9e0db56f7cb906d56fcbfb.jpg" class="image">
//<div class="content">
//    <text>{$name}</text>
//</div>
//</body>
//</html>
//EOF;

        $htmlTemplate = <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>双十一电商活动</title>
    <script src="https://res2.owohpet.cn/web/rem.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            width: 100%;
            overflow-x: hidden;
        }
        a {
            display: block;
        }
        .bg1 {
            width: 100%;
            height: 0;
            padding-bottom: 90%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg1.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg2 {
            width: 100%;
            height: 0;
            padding-bottom: 117.73%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg2.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg3 {
            width: 100%;
            height: 0;
            padding-bottom: 165.33%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg3.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg3_1 {
            width: 100%;
            height: 0;
            padding-bottom: 41.73%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg3_1.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg3_2 {
            width: 100%;
            height: 0;
            padding-bottom: 32.13%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg3_2.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg3_3 {
            width: 100%;
            height: 0;
            padding-bottom: 31.33%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg3_3.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg3_4 {
            width: 100%;
            height: 0;
            padding-bottom: 60.13%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg3_4.jpg') no-repeat center center;
            background-size: cover;
        }
        .bg4 {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 124.13%;
            background: url('https://res2.owohpet.cn/web/owoh_11_electricity_activity/bg4.jpg') no-repeat center center;
            background-size: cover;
        }
        /*.qrcode-box {*/
        /*    position: absolute;*/
        /*    left: 50%;*/
        /*    bottom: 8%;*/
        /*    margin-left: -15%;*/
        /*    width: 30%;*/
        /*    height: 0;*/
        /*    padding-bottom: 30%;*/
        /*    box-shadow: 0.145rem 0.25rem 0.57rem rgba(116,64,116,0.5);*/
        /*}*/
        /*.text {*/
        /*    position: absolute;*/
        /*    bottom: 33%;*/
        /*    width: 100%;*/
        /*    text-align: center;*/
        /*    font-size: 0.24rem;*/
        /*    color: rgba(0, 0, 0, 0.5);*/
        /*}*/
        .qrcode {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="bg1"></div>
    <div class="bg2"></div>
    <!-- <div class="bg3"></div> -->
    <div class="bg3_1"></div>
    <a class="bg3_2" href="owoh://eshop?region=china&url=https%3A%2F%2F100000578934.retail.n.weimob.com%2Fsaas%2Fretail%2F100000578934%2F240077934%2Fshop%2Findex%3Fessharewid%3D1430529241%26id%3D519228"></a>
    <a class="bg3_3" href="owoh://eshop?region=china&url=https%3A%2F%2F100000578934.retail.n.weimob.com%2Fsaas%2Fretail%2F100000578934%2F240077934%2Fshop%2Findex%3Fessharewid%3D1430529241%26id%3D519228"></a>
    <div class="bg3_4"></div>
    <div class="bg4">
        <div class="text">
            <p>OwOh 宠物生活馆官方客服</p>
            <p>微信号: owoh0315</p>
        </div>
        <div class="qrcode-box">
            <img class="qrcode" src="https://res2.owohpet.cn/web/owoh_11_electricity_activity/qrcode.png" alt="">
        </div>
    </div>
</div>
</body>
</html>

EOF;
        $output = __DIR__ . '/../../../public/demo/' . time() . '.jpg';
        $imageSnappy->generateFromHtml($htmlTemplate, $output);

        echo 'ok';
    }
}
