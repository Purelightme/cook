<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/12/31
 * Time: 22:00
 */

namespace App\Services;


use EasyWeChat\Factory;

class WeappService
{
    public static function init()
    {
        return Factory::miniProgram(config('wechat'));
    }

    /**
     * 解析用户基本信息
     * @param $code
     * @param $iv
     * @param $rowData
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function login($code, $iv, $rowData)
    {
        $app = self::init();
        $res = $app->auth->session($code);
        return $app->encryptor->decryptData($res['session_key'],$iv,$rowData);
    }
}