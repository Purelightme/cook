<?php

namespace App\Console\Commands;

use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportCategoryFromMob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-category:mob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从Mob API拉取菜谱分类数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fire = '🔥 ';
        $url = 'http://apicloud.mob.com/v1/cook/category/query?key=' . config('cook.mob.appKey');
        $client = new Client();
        $response = $client->get($url);
        $res = json_decode((string)$response->getBody(), true);
        if ($res['msg'] != 'success') {
            $this->error('请求mob菜谱分类失败');
            return;
        }
        $this->info('开始导入分类。');
        $root = Category::create([
            'parent_id' => 0,
            'title' => $res['result']['categoryInfo']['name'],
            'mob_ctg_id' => $res['result']['categoryInfo']['ctgId']
        ]);
        if ($root)
            $this->info(str_repeat($fire,1).'顶级分类：'.$root->title.'创建完成。');
        $items = $res['result']['childs'];
        foreach ($items as $item){
            $parent = Category::getCategoryByMobCtgId($item['categoryInfo']['parentId']);
            $secondCategory = Category::create([
                'parent_id' => $parent->id,
                'title' => $item['categoryInfo']['name'],
                'mob_ctg_id' => $item['categoryInfo']['ctgId']
            ]);
            if ($secondCategory){
                $this->info(str_repeat($fire,2).'二级分类：'.$secondCategory->title.'创建完成。');
                foreach ($item['childs'] as $child){
                    $thirdCategory = Category::create([
                        'parent_id' => $secondCategory->id,
                        'title' => $child['categoryInfo']['name'],
                        'mob_ctg_id' => $child['categoryInfo']['ctgId']
                    ]);
                    if ($thirdCategory){
                        $this->info(str_repeat($fire,3).'三级分类：'.$thirdCategory->title.'创建完成。');
                    }
                }
            }
        }
        $this->info('全部分类导入完成。');
    }
}
