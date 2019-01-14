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
        $config = [
            'app_id' => config('wechat.mini_program.default.app_id'),
            'secret' => config('wechat.mini_program.default.secret'),

            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => storage_path('logs').'/wechat.log',
            ],
        ];
        return Factory::miniProgram($config);
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

    public static function generateWXACodeUnlimit($path)
    {
        $app = self::init();
        $response = $app->app_code->getQrCode($path, 280);
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            $filename = $response->saveAs(public_path('imgs/weapp'), 'weapp.png');
        }
        return $filename;
    }
}