<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $guarded = [];

    /*********模型关联区*********/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*********自定义方法*********/

    /**
     * 新建留言
     * @param $userId
     * @param $content
     * @return $this|Model
     */
    public static function newSuggest($userId,$content)
    {
        $suggest = self::create([
            'user_id' => $userId,
            'content' => $content
        ]);
        return $suggest;
    }
}
