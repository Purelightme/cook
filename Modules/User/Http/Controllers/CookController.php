<?php

namespace Modules\User\Http\Controllers;

use App\Http\Config\AdminConfig;
use App\Http\Resources\CookDetailResource;
use App\Http\Resources\CookListResource;
use App\Models\Cook;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\CookRequest;

class CookController extends Controller
{
    /**
     * 我的菜谱
     * Display a listing of the resource.
     * @return array
     */
    public function index(CookRequest $request)
    {
        $cooks = $request->user('api')->cooks()->paginate($request->pageSize ?? AdminConfig::PAGE_SIZE);
        CookListResource::collection($cooks);
        return ResponseTool::buildSuccess($cooks);
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
     * 上传菜谱
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return array
     */
    public function store(CookRequest $request)
    {
        $user = $request->user('api');
        $cook = Cook::NewCook($user->id,$request->all());
        $cook = new CookDetailResource($cook);
        return ResponseTool::buildSuccess($cook);
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
     * 更新菜谱
     * Update the specified resource in storage.
     * @param  Request $request
     * @return array
     */
    public function update(CookRequest $request,$cookId)
    {
        $cook = Cook::updateUserCook($cookId,$request);
        $cook = new CookDetailResource($cook);
        return ResponseTool::buildSuccess($cook);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
