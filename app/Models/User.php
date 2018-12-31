<?php

namespace App\Models;

use App\Exceptions\LogicException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    protected $guarded = [];

    const PASSWORD = '123456';
    const SCENE = 'weapp';

    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /************自定义方法**********/

    /**
     * 获取|创建用户
     * @param $openid
     * @param $userInfo
     * @return $this|\Illuminate\Database\Eloquent\Model|null|object|static
     * @throws LogicException
     */
    public static function getOrCreate($openid,$userInfo)
    {
        $user = self::getUserByOpenid($openid);
        if (!$user){
            $user = User::create([
                'openid' => $openid,
                'avatar' => $userInfo['avatarUrl'],
                'nickname' => $userInfo['nickName'],
                'password' => bcrypt(self::PASSWORD),
            ]);
        }
        return $user;
    }

    /**
     * @param $openid
     * @param bool $throw
     * @throws LogicException
     */
    public static function getUserByOpenid($openid, $throw = false)
    {
        $model = new self();
        $user = $model->where('openid',$openid)->first();
        if ($throw && !$user)
            throw new LogicException(LogicException::EXCEPTION_USER_NOT_FOUND);
        return $user;
    }

    public static function getToken(self $user)
    {
        return $user->createToken(self::SCENE)->accessToken;
    }
}
