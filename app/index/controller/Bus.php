<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Bus extends BaseController

{
    public function index()
    {
        $citySelect = [
            '东莞市',
            '深圳市',
            '广州市'
        ];

        $stationSelect = [
//            '东莞市' => ['理工学院体育中心（公交站）', '松山湖候机楼'],
//            '深圳市' => ['世界之窗地铁站C1出口'],
//            '广州市' => [],
        ];

        foreach ($citySelect as $value) {
            // 根据接口获取站点
            $data = curlRequest('https://passenger.wyebus.com/api/v3/city/station/list', 'post', http_build_query(['cityName' => $value, 'lineType' => 2, 'searchType' => 1]), ['Content-Type: application/x-www-form-urlencoded']);
            $data = json_decode($data, true);
            $all = $data['data']['districtList'][0]['stationList'];
            $stationArr = [];
            if (!empty($all)) {
                $stationArr = array_column($all, 'stationName');
            }
            $stationSelect[$value] = $stationArr;
        }

        View::assign('citySelect', $citySelect);
        View::assign('today', date('Y-m-d'));
        View::assign('stationSelect', json_encode($stationSelect, 256));
        return View::fetch('index');
    }

    public function ask()
    {
        $param = Request::instance()->param();
        try {
            $data = [
                'cityStart' => $param['cityStart'] ?? '深圳市',
                'stationStart' => $param['stationStart'] != '不限' ? $param['stationStart'] : '',
                'cityEnd' => $param['cityEnd'] ?? '东莞市',
                'stationEnd' => $param['stationEnd'] !='不限' ? $param['stationEnd'] : '',
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
            $data = ['status' => 0, 'msg' => '查无数据'];
            if (!empty($res['code']) && !empty($res['data']['pageEntity']['list'])) {
                $data = [
                    'status' => 1,
                    'data' => $res['data']['pageEntity']['list'],
                ];
            }
            return json($data);
        } catch (\Exception $e) {
            $res = ['status' => -1, 'msg' => $e->getMessage()];
            return json($res);
        }
    }
}
