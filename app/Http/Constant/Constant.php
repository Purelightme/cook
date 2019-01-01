<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2018/12/31
 * Time: 11:59
 */

namespace App\Http\Constant;


class Constant
{
    const COOK_SOURCE_JVHE = 'https://www.jvhe.cn';
    const COOK_SOURCE_MOB = 'http://apicloud.mob.com';

    /**********laravel-admin***********/
    const SWITCH_STATE = [
        'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
    ];

    /*********性别**********/
    const SEX_MAP = [
        self::SEX_UNKNOWN => '未知',
        self::SEX_BOY => '男',
        self::SEX_GIRL => '女'
    ];
    const SEX_UNKNOWN = 0;
    const SEX_BOY = 1;
    const SEX_GIRL = 2;
}