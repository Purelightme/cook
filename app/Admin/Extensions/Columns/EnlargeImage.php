<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2019/1/29
 * Time: 17:30
 */

namespace App\Admin\Extensions\Columns;


use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class EnlargeImage extends AbstractDisplayer
{

    /**
     * Display method.
     *
     * @return mixed
     */
    public function display(\Closure $callback = null)
    {
        $callback = $callback->bindTo($this->row);
        $script = <<<JS

$(document).ready(function () {
    let imgs = document.getElementsByClassName('change')
    let img_length = imgs.length
    for(let i=0;i < img_length;i++){
        (function(i){
            imgs[i].onclick=function(){
                if($(this).css('z-index') == 2){
                    $(this).removeClass('larger')
                }else{
                    $(this).addClass('larger')
                }
            }
        })(i)
    }
})

JS;
        $css = <<<CSS
.larger {
    z-index: 2;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 100%;
    max-height: 100%;
    min-width: 600px;
    min-height: 600px;
    width: auto;
    height: auto;
    box-sizing: content-box;
    border: 100px solid rgba(0, 0, 0, .5);
    border-radius: 10px;
}
CSS;
        Admin::css($css);
        Admin::script($script);
        $path = call_user_func($callback);
        return '<img src='.getImageUrl($path).' style="width:80px;height:80px" class="change"></img>';
    }

}