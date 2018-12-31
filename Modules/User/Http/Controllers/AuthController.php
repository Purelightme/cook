<?php

namespace Modules\User\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\WeappService;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     * @throws \App\Exceptions\LogicException
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(AuthRequest $request)
    {
        $code    = str_replace(' ','+',$request->code);
        $iv      = str_replace(' ','+',$request->iv);
        $rowData = str_replace(' ','+',$request->rowData);
        $wxInfo  = WeappService::login($code,$iv,$rowData);
        $user    = User::getOrCreate($wxInfo['openId'],$wxInfo);
        return ResponseTool::buildSuccess([
            'user' => new UserResource($user),
            'access_token' => User::getToken($user)
        ]);
    }
}
