<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/12/31
 * Time: 22:13
 */

namespace App\Exceptions;


use Throwable;

class LogicException extends CommonException
{
    const EXCEPTION_MAP = [
        self::EXCEPTION_USER_NOT_FOUND => '未找到该用户',
        self::EXCEPTION_DB_ERROR => '服务异常，稍后再来吧...',
        self::EXCEPTION_SIGN_ERROR => '签名有误',
        self::EXCEPTION_PERMISSION_DENY => '暂无权限访问该资源',
    ];

    const EXCEPTION_USER_NOT_FOUND = 1000;
    const EXCEPTION_DB_ERROR = 1001;
    const EXCEPTION_SIGN_ERROR = 1002;
    const EXCEPTION_PERMISSION_DENY = 1003;





    public function __construct(int $code = 0, string $message = "", Throwable $previous = null)
    {
        if (isset(self::EXCEPTION_MAP[$code]))
            $message = !empty($message) ? $message : self::EXCEPTION_MAP[$code];
        parent::__construct($message, $code, $previous);
    }
}