<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Constant\Constant;
use App\Http\Resources\StoryDetailResource;
use App\Http\Resources\StoryListResource;
use App\Models\Story;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index(Request $request)
    {
        $model = new Story();
        $stories = $model->orderByDesc('updated_at')
            ->paginate($request->pageSize ?? 30);
        StoryListResource::collection($stories);
        return ResponseTool::buildSuccess($stories);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('common::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return mixed
     */
    public function show(Request $request,$id)
    {
        $story = Story::find($id);
        return new StoryDetailResource($story);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('common::edit');
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
