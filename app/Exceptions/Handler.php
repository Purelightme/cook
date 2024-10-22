<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException){
            return $this->unauthenticated($request);
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception = null)
    {
        return response()->json([
            'errcode' => 2000,
            'errmsg'  => '需要登录'
        ],200);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $errmsg = '';
        foreach ($exception->errors() as $index => $error){
            if ($index == 0){
                $errmsg = $error[0];
            }
        }
        return response()->json([
            'errcode' => 2001,
            'errmsg'  => $errmsg,
            'result'    => $exception->errors()
        ],200);
    }
}
