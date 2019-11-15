<?php
namespace app\index\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        $citySelect = [
            '东莞市',
            '深圳市',
            '广州市'
        ];
        $stationSelect = [
            '东莞市' => ['理工学院体育中心（公交站）', '松山湖候机楼'],
            '深圳市' => ['世界之窗地铁站C1出口'],
            '广州市' => [],
        ];
        View::assign('citySelect', $citySelect);
        View::assign('stationSelect', json_encode($stationSelect, 256));
        return view();
    }
}
