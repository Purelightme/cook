<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2019/1/8
 * Time: 19:54
 */

namespace App\Tools\Sign;


use App\Exceptions\LogicException;
use Illuminate\Support\Carbon;

class ParamsSignature
{
    /**
     * 比较签名
     * @param array $params
     * @throws LogicException
     */
    public static function check(array $params)
    {
        $sign = self::generateSign($params);
        if ($sign != $params['sign'])
            throw new LogicException(LogicException::EXCEPTION_SIGN_ERROR);
    }

    /**
     * 计算签名
     * @param array $params
     * @return string
     * @throws LogicException
     */
    public static function generateSign(array $params)
    {
        unset($params['sign']);
        if (!isset($params['timestamp']) ||
            Carbon::now()->addMinutes(30)->lt(Carbon::createFromTimestamp($params['timestamp'])) ||
            Carbon::now()->subMinutes(30)->gt(Carbon::createFromTimestamp($params['timestamp'])) )
            throw new LogicException(LogicException::EXCEPTION_SIGN_ERROR);
        sort($params,SORT_STRING);
        $string = '';
        foreach ($params as $key => $value){
            $string .= $key.$value;
        }
        return md5($string.$params['timestamp']);
    }
}