<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Bus extends BaseController

{
    public function index()
    {
        return View::fetch('index');
    }

    public function ask()
    {
        $param = Request::instance()->param();
        try {
            $data = [
                'cityStart' => $param['cityStart'] ?? '深圳市',
                'stationStart' => $param['stationStart'] ?? '世界之窗地铁站C1出口',
                'cityEnd' => $param['cityEnd'] ?? '东莞市',
                'stationEnd' => $param['stationEnd'] ?? '理工学院体育中心（公交站）',
                'schDate' => $param['schDate'] ?? date('Y-m-d', time()),
                'lineType' => '2',
                'page' => '1',
                'size' => '100',
//                'startIsHuanDao' => '2',
//                'endIsHuanDao' => '2',
//                'stationCode' => 'ST0194',
//                'dstStationCode' => 'ST0290',
            ];
            $header = [
                'Content-Type: application/x-www-form-urlencoded'
            ];
            $data = http_build_query($data);
            $res = curlRequest('https://passenger.wyebus.com/api/v2/passenger/plan/intercity/page', 'post', $data, $header);
            $res = json_decode($res, true);
//            $res = end($res['data']['pageEntity']['list']);
            return json($res);
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
