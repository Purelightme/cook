<?php

namespace App\Http\Controllers;

use App\Models\Search;
use App\Models\User;
use App\Services\ImageService;
use App\Services\WeappService;
use App\Tools\Upload\Upload;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
//        ImageService::cropQrcode();
//        return WeappService::generateWXACodeUnlimit('pages/index/index');
        ImageService::getUserPosterByIndex(User::findOrFail(1),1);
    }
}
