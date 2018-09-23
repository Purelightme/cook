<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/9/25
 * Time: 15:45
 */

namespace App\Exceptions;


use Throwable;

class SmsException extends \Exception
{
    const EXCEPTION_MAP = [
        self::EXCEPTION_PHONE_INVALID  => '手机号格式错误',
        self::EXCEPTION_PARAMS_INVALID => '参数错误',
        self::EXCEPTION_NO_GATEWAY     => '暂无可用的短信服务商',
        self::EXCEPTION_MUST_WAIT      => '请稍后再试',
    ];

    const EXCEPTION_PHONE_INVALID  = 3000;
    const EXCEPTION_PARAMS_INVALID = 3001;
    const EXCEPTION_NO_GATEWAY     = 3002;
    const EXCEPTION_MUST_WAIT      = 3003;

    public function __construct(int $code = 0, string $message = "", Throwable $previous = null)
    {
        if (isset(self::EXCEPTION_MAP[$code]))
            $message = !empty($message) ? $message : self::EXCEPTION_MAP[$code];
        parent::__construct($message, $code, $previous);
    }
}