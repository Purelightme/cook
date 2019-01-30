<?php

namespace Modules\User\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(UserRequest $request)
    {
        return ResponseTool::buildSuccess(new UserResource($request->user('api')));
    }
}
