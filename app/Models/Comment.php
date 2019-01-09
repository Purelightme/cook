<?php

namespace App\Models;

use App\Exceptions\LogicException;
use App\Tools\Upload\UploadTool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $guarded = [];
    protected $casts = [
        'imgs' => 'array',
    ];

    /**********模型关联*********/

    public function cook()
    {
        return $this->belongsTo(Cook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**********自定义方法*********/

    /**
     * 发布评论
     * @param User $user
     * @param array $params
     * @return Comment
     * @throws LogicException
     */
    public static function NewComment(User $user,array $params)
    {
        $comment = new self();
        $comment->user_id = $user->id;
        $comment->conetnt = $params['content'];
        if ($comment->save())
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        return $comment;
    }

    /**
     * 补充评论图片
     * @param User $user
     * @param $id
     * @param $file
     * @return \Illuminate\Database\Eloquent\Collection|Model
     * @throws LogicException
     */
    public static function addCommentImg(User $user,$id,$file)
    {
        $comment = self::findOrFail($id);
        if ($comment->user_id != $user->id)
            throw new LogicException(LogicException::EXCEPTION_PERMISSION_DENY);
        $upload = new UploadTool('local',2,['jpg','jpeg','png','gif']);
        $name = $upload->uploadSingleFile($file,'comment/imgs');
        try {
            DB::transaction(function () use ($name, $comment) {
                DB::raw('SET TRANSACTION ISOLATION LEVEL serializable');
                $old = !empty($comment->imgs) ? $comment->imgs : [];
                $old[] = $name;
                $comment->imgs = $old;
                $comment->saveOrFail();
            });
        } catch (\Throwable $e) {
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        }
        return $comment;
    }

}
