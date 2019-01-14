<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2019/1/12
 * Time: 15:26
 */

namespace App\Services;


use App\Models\User;

class ImageService
{
    public static function getUserPosterByIndex(User $user,$index)
    {
        $template = \Image::make(public_path('imgs/template/'.$index.'.png'));
        $avatar = \Image::make($user->avatar);
        $avatar->resize($avatar->width() * 2,$avatar->height() * 2);
        $weapp = \Image::make(public_path('imgs/weapp/weapp_crop.png'));
        $template->insert($avatar,'bottom-left',500,100);
        $template->insert($weapp,'bottom-right',480,100);
        $template->save(public_path('imgs/result/test.png'));
    }

    public static function cropQrcode()
    {
        $qrcode = \Image::make(public_path('imgs/weapp/weapp.png'));
        $qrcode->crop(263,263,10,10);
        $qrcode->save(public_path('imgs/weapp/weapp_crop.png'));
    }
}