<?php
namespace app\index\controller;


use app\BaseController;
use app\index\model\User;
use think\facade\Config;
use think\facade\View;
use think\Request;

class WeChat extends BaseController
{
    /**
     * @param \think\Request $request
     * 微信登录
     * @return string|\think\response\Redirect
     * author lkz <oldmatch24@gmail.com>
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index(Request $request)
    {
        $code = $request->param('code');
        $wechat = Config::get('app.wechat');
        $appid = $wechat['appid'];
        $secret = $wechat['secret'];

        $redirect_uri = urlencode($request->domain() . $request->url());
        // 没有code先去获取
        if (empty($code)) {
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            return redirect($url);
        } else {
            // 有code，获取access_token(微信网页授权access_token，非普通)
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            $res = curlRequest($url);
            $res = json_decode($res, true);
            if (isset($res['errcode']) || empty($res['openid']) || empty($res['access_token'])) {
                // 失败
                return redirect($redirect_uri);
            }

            // 判断用户是否存在
            $userModel = new User();
            $info = $userModel->where('openid', $res['openid'])->find();
            if (empty($info)) {
                // 查询用户信息插入用户
                $accessToken = $res['access_token'];
                $openid = $res['openid'];
                $userUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=$accessToken&$openid=&lang=zh_CN";
                $userInfo = curlRequest($userUrl);
                $userInfo = json_decode($userInfo, true);

                $insert = [
                    'nickname' => $userInfo['nickname'],
                    'phone' => $userInfo['nickname'],
                    'avatar' => $userInfo['headimgurl'],
                    'openid' => $openid,
                ];
                $userModel->save($insert);
                $info = $insert;
            } else {
                // 更新用户信息
            }

            $data = [
                'nickname' => $info['nickname'],
                'phone' => $info['phone'],
                'avatar' => $info['avatar'],
            ];
        }

        return View::fetch('', $data);
    }
}
