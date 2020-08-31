<?php
namespace app\index\controller;

use app\BaseController;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        return view();
    }

    public function notPage()
    {
        return view();
    }

    public function test()
    {
        $res = Db::name('user')->select();
        $data = Db::connect('db_mongo')
            ->table('lkz')
            ->where('_id', '5e26bed01b1135adbaf7733c')
            ->select();
        return json($data);
    }

    public function sendSms()
    {
        $schDate = $this->request->param('schDate', '');
        $schTime = $this->request->param('schTime', '');
        $surplus = $this->request->param('surplus', '');
        $password = $this->request->param('password', '');
        if ($password != 'lkz是最帅的') {
            return json(['status' => 0, 'msg' => '您是傻逼']);
        }

        try {
            $this->sendWeChatNotify($schDate, $schTime, $surplus);
        } catch (\Exception $exception) {

        }

        $config = [
            'accessKeyId'    => env('sms.access_key_id'),
            'accessKeySecret' => env('sms.access_key_secret'),
        ];

        $client  = new Client($config);
        $sendSms = new SendSms();
        $sendSms->setPhoneNumbers(18218253403);
        $sendSms->setSignName('oldmatch');
        $sendSms->setTemplateCode('SMS_200723205');
        $sendSms->setTemplateParam(['code' => 'ticket']);
        $res = $client->execute($sendSms);
        if (empty($res) || $res->Code !== 'OK') {
            return json(['status' => 0, 'msg' => '发送失败']);
        }

        return json(['status' => 1, 'msg' => '发送成功']);
    }

    public function sendWeChatNotify($schDate, $schTime, $surplus)
    {
        $data = [
            'text' => '您的车次：' . date('m月d日H时i分', strtotime($schDate . ' ' . $schTime)) . '有票了',
            'desp' => "车次：$schDate $schTime  余票：$surplus",
        ];
        $url = 'https://sc.ftqq.com/' . env('sckey.secret') . '.send?' . http_build_query($data);
        file_get_contents($url);
    }
}
