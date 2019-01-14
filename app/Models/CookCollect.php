<?php

namespace App\Models;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Model;

class CookCollect extends Model
{
    protected $guarded = [];

    /********模型关联*******/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cook()
    {
        return $this->belongsTo(Cook::class);
    }

    /********自定义方法*******/

    /**
     * 收藏
     * @param $userId
     * @param $cookId
     * @return CookCollect
     * @throws LogicException
     */
    public static function NewCookCollect($userId,$cookId)
    {
        $model = new self();
        $model->user_id = $userId;
        $model->cook_id = $cookId;
        if (!$model->save())
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        return $model;
    }

    /**
     * 是否已经收藏过
     * @param $userId
     * @param $cookId
     * @return bool
     */
    public static function isCollected($userId,$cookId)
    {
        $model = new self();
        return $model->where('user_id',$userId)->where('cook_id',$cookId)->exists();
    }

}
