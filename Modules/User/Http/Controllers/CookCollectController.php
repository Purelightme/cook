<?php

namespace Modules\User\Http\Controllers;

use App\Exceptions\LogicException;
use App\Http\Config\AdminConfig;
use App\Http\Resources\CookCollectListResource;
use App\Models\CookCollect;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CookCollectRequest;

class CookCollectController extends Controller
{
    /**
     * 我的收藏
     * Display a listing of the resource.
     * @return array
     */
    public function index(CookCollectRequest $request)
    {
        $user = $request->user('api');
        $collects = $user->cook_collects()->with(['cook'])->paginate($request->pageSize ?? AdminConfig::PAGE_SIZE);
        CookCollectListResource::collection($collects);
        return ResponseTool::buildSuccess($collects);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * 收藏菜谱
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return array
     */
    public function store(CookCollectRequest $request)
    {
        $user = $request->user('api');
        if (CookCollect::isCollected($user->id,$request->cook_id))
            throw new LogicException(LogicException::EXCEPTION_HAS_COLLECTED);
        CookCollect::NewCookCollect($user->id,$request->cook_id);
        return ResponseTool::buildSuccess();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * 取消收藏菜谱
     * Remove the specified resource from storage.
     * @return array
     */
    public function destroy(CookCollectRequest $request)
    {
        $user = $request->user('api');
        if (!CookCollect::isCollected($user->id,$request->cook_id))
            throw new LogicException(LogicException::EXCEPTION_HAS_NOT_COLLECTED);
        $collect = (new CookCollect())
            ->where('user_id',$user->id)
            ->where('cook_id',$request->cook_id)
            ->first();
        if (!$collect->delete())
            throw new LogicException(LogicException::EXCEPTION_DB_ERROR);
        return ResponseTool::buildSuccess();
    }
}
