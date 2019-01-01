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

    /************模型关联**********/

    public function suggests()
    {
        return $this->hasMany(Suggest::class);
    }

    /************自定义方法**********/

    /**
     * 获取|创建用户
     * @param $openid
     * @param $userInfo
     * @return $this|\Illuminate\Database\Eloquent\Model|null|object|static
     * @throws LogicException
     */
    public static function getOrCreate($openid, $userInfo)
    {
        $user = self::getUserByOpenid($openid);
        if (!$user) {
            $user = new self();
            $user->openid = $openid;
            $user->avatar = $userInfo['avatarUrl'];
            $user->nickname = $userInfo['nickName'];
            $user->sex = $userInfo['gender'];
            $user->country = $userInfo['country'];
            $user->province = $userInfo['province'];
            $user->city = $userInfo['city'];
            $user->password = bcrypt(self::PASSWORD);
            if (!$user->save())
                throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
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
        $user = $model->where('openid', $openid)->first();
        if ($throw && !$user)
            throw new LogicException(LogicException::EXCEPTION_USER_NOT_FOUND);
        return $user;
    }

    public static function getToken(self $user)
    {
        return $user->createToken(self::SCENE)->accessToken;
    }

    public static function options()
    {
        $users = self::all();
        return array_combine($users->pluck('id')->toArray(),
            $users->pluck('nickname')->toArray());
    }

}
