<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Config\AdminConfig;
use App\Http\Resources\CookDetailResource;
use App\Http\Resources\CookListResource;
use App\Models\Cook;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CookController extends Controller
{
    /**
     * 根据分类id获取菜谱列表
     * @param Request $request
     * @param $categoryId
     * @return array
     */
    public function categoryCooks(Request $request,$categoryId)
    {
        $cook = new Cook();
        $cooks = $cook->where('category_ids','like',"%{$categoryId}%")
            ->paginate($request->pageSize ?? AdminConfig::PAGE_SIZE);
        CookListResource::collection($cooks);
        return ResponseTool::buildSuccess($cooks);
    }

    /**
     * 菜谱模糊搜索
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $cook = new Cook();
        $cooks = $cook->where('title','like',"%{$request->search}%")
            ->paginate($request->pageSize ?? AdminConfig::PAGE_SIZE);
        CookListResource::collection($cooks);
        return ResponseTool::buildSuccess($cooks);
    }

    /**
     * 菜谱详情
     * @param Request $request
     * @param $id
     * @return array
     */
    public function detail(Request $request,$id)
    {
        $cook = Cook::findOrFail($id);
        return ResponseTool::buildSuccess(new CookDetailResource($cook));
    }
}
