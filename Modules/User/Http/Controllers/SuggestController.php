<?php

namespace Modules\User\Http\Controllers;

use App\Http\Resources\SuggestResource;
use App\Models\Suggest;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\SuggestRequest;

class SuggestController extends Controller
{
    /**
     * 留言记录
     * Display a listing of the resource.
     * @return mixed
     */
    public function index(SuggestRequest $request)
    {
        $suggests = $request->user('api')->suggests()->paginate($request->pageSize ?? 10);
        SuggestResource::collection($suggests);
        return ResponseTool::buildSuccess($suggests);
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
     * 留言
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return mixed
     */
    public function store(SuggestRequest $request)
    {
        $suggest = Suggest::newSuggest($request->user('api')->id,$request->input('content'));
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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
