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
    ];

    const EXCEPTION_USER_NOT_FOUND = 1000;





    public function __construct(int $code = 0, string $message = "", Throwable $previous = null)
    {
        if (isset(self::EXCEPTION_MAP[$code]))
            $message = !empty($message) ? $message : self::EXCEPTION_MAP[$code];
        parent::__construct($message, $code, $previous);
    }
}