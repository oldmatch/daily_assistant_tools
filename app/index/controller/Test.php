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
//        $ttf = __DIR__ . '/../../../public/ttf/sc.ttc';
        // 需要合成的图片地址，base64也可以的，其实跟这个也无关，主要是html能静态展示，那么合成的就是什么样的
        $name = '2343242343434adsad';

// html代码，随意搞了搞，真实使用的话，需要用心调整样式哦~
        $htmlTemplate = <<<EOF
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>海报</title>
</head>
<style>
    @font-face {
        font-family: myFirstFont;
    }

    body {
        font-family: myFirstFont;
        text-align: center;
        padding: 100px;
        background: #8B91A0;
    }

    .image {
        width: 300px;
        height: 300px;
        position: relative;
    }

    .content {
        background: white;
        width: 300px;
        position: absolute;
        top: 380px;
        left: 520px;
    }
</style>
<body>
<img src="https://owohac-oss.oss-cn-shenzhen.aliyuncs.com/adopt/admin_web/202005/08/8e64d2139b9e0db56f7cb906d56fcbfb.jpg" class="image">
<div class="content">
    <text>{$name}</text>
</div>
</body>
</html>
EOF;
        $output = __DIR__ . '/../../../public/demo/' . time() . '.jpg';
        $imageSnappy->generateFromHtml($htmlTemplate, $output);

        echo 'ok';
    }
}
