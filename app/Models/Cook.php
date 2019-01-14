<?php

namespace App\Models;

use App\Exceptions\LogicException;
use App\Tools\Upload\UploadTool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cook extends Model
{
    protected $guarded = [];

    protected $casts = [
        'method' => 'array',
        'mob_ctg_ids' => 'array',
    ];

    const SOURCE_MAP = [
        self::SOURCE_MOB => 'mob',
        self::SOURCE_USER => 'user',
        self::SOURCE_JISU => 'jisu',
    ];
    const SOURCE_MOB = 1;
    const SOURCE_USER = 2;
    const SOURCE_JISU = 3;

    /***********自定义方法**********/

    /**
     * 根据mob menu_id获取菜谱
     * @param $menuId
     * @return Model|null|object|static
     */
    public static function getCookByMenuId($menuId)
    {
        $model = new self();
        return $model->where('menu_id',$menuId)->first();
    }

    public static function NewCook($userId,array $params)
    {
        $cook = new self();
        $cook->user_id = $userId;
        $cook->title = $params['title'];
        $cook->category_ids = $params['category_ids'];
        $cook->category_titles = Category::getCategoryTitlesByIds($params['category_ids']);
        $cook->introduction = $params['introduction'];
        $cook->ingredients = $params['ingredients'];
        $cook->method = '';
        $cook->source = Cook::SOURCE_USER;
        if (!$cook->save())
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        return $cook;
    }

    /**
     * 编辑菜谱
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|Model
     * @throws LogicException
     */
    public static function updateUserCook($cookId,Request $request)
    {
        $cook = self::isUserCook($request->user('api')->id,$cookId);
        $upload = new UploadTool('local',2,'image');
        if ($request->hasFile('img')){
            $img = $upload->uploadSingleFile($request->file('img'),'cooks/user/imgs');
            $cook->img = $img;
        }
        if ($request->hasFile('step_img') && $request->has('step_img_index')){
            $stepImg = $upload->uploadSingleFile($request->file('step_img'),'cooks/user/step_imgs');
            $old = $cook->method;
            $old[$request->step_img_index]['img'] = $stepImg;
            $cook->method = $old;
        }
        if ($request->has('title'))
            $cook->title = $request->title;
        if ($request->has('category_ids')){
            Category::checkCategoryIds($request->category_ids);
            $cook->category_ids = $request->category_ids;
            $cook->category_titles = Category::getCategoryTitlesByIds($request->category_ids);
        }
        if ($request->has('introduction'))
            $cook->introduction = $request->introduction;
        if ($request->has('ingredients'))
            $cook->ingredients = $request->ingredients;
        if (!$cook->save())
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        return $cook;
    }

    /**
     * 检查用户是否是该菜谱作者
     * @param $userId
     * @param $cookId
     * @return Cook
     */
    public static function isUserCook($userId,$cookId)
    {
        $first = (new self())->where('user_id',$userId)
            ->where('id',$cookId)
            ->first();
        if (!$first)
            throw new LogicException(LogicException::EXCEPTION_PERMISSION_DENY);
        return $first;
    }
}
