<?php
namespace app\index\controller;

use think\facade\Db;

class Index
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
}
