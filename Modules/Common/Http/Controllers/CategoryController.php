<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Tools\Response\ResponseTool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * 获取分类树
     * @return array
     */
    public function tree()
    {
        $data = (new Category())->buildTree('id','parent_id','title');
        return ResponseTool::buildSuccess($data);
    }
}
