<?php
namespace app\index\controller;

use think\facade\View;

class Bus
{
    public function index()
    {
        return View::fetch('index');
    }

    public function ask()
    {
        try {
            $data = [
                'cityStart' => '深圳市',
                'stationStart' => '世界之窗地铁站C1出口',
                'cityEnd' => '东莞市',
                'stationEnd' => '理工学院体育中心（公交站）',
                'schDate' => '2019-11-01',
                'lineType' => '2',
                'page' => '1',
                'size' => '10',
                'startIsHuanDao' => '2',
                'endIsHuanDao' => '2',
                'stationCode' => 'ST0194',
                'dstStationCode' => 'ST0290',
            ];
            $header = [
                'Content-Type: application/x-www-form-urlencoded'
            ];
            $data = http_build_query($data);
            $res = curlRequest('https://passenger.wyebus.com/api/v2/passenger/plan/intercity/page', 'post', $data, $header);
            $res = json_decode($res, true);
            $res = end($res['data']['pageEntity']['list']);
            if (!empty($res['surplus'])) {
                $res = ['status' => 1, 'msg' => '有票了。。。。。。。' . $res['station']];
            } else {
                $res = ['status' => 0, 'msg' => '没票啊' . date('Y-m-d H:i:s')];
            }
            return json($res);
        } catch (\Exception $e) {
            $res = ['status' => -1, 'msg' => $e->getMessage()];
            return json($res);
        }
    }
}
