<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Cook;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportCategoryCookFromMob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-cook:mob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从mob API根据分类id导入菜谱';

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
        $tmpPageSize = 1;
        $pageSize = 500;
        $url = 'http://apicloud.mob.com/v1/cook/menu/search';
        $rootCategory = Category::first();
        foreach ($rootCategory->children as $secondCategory){
            $thirdCategories = $secondCategory->children;
            foreach ($thirdCategories as $thirdCategory){
                $this->info(str_repeat($fire,1).'开始导入分类：'.$thirdCategory->title.'的菜谱。');
                try{
                    $client = new Client();
                    $response = $client->request('GET',$url,[
                        'query' => [
                            'cid' => $thirdCategory->mob_ctg_id,
                            'page' => 1,
                            'size' => $tmpPageSize,
                            'key' => config('cook.mob.appKey')
                        ],
                        'connect_timeout' => 3600,
                    ]);
                    $res = json_decode((string) $response->getBody(),true);
                    if ($res['msg'] != 'success'){
                        $this->info('暂无分类：'.$thirdCategory->title.'的菜谱');
                        continue;
                    }
                }catch (\Throwable $exception){
                    continue;
                }
                $pages = ceil($res['result']['total'] / $pageSize);
                for ($i = 0;$i < $pages;$i++){
                    try{
                        $client = new Client();
                        $response = $client->request('GET',$url,[
                            'query' => [
                                'cid' => $thirdCategory->mob_ctg_id,
                                'page' => $i,
                                'size' => $pageSize,
                                'key' => config('cook.mob.appKey')
                            ],
                            'connect_timeout' => 3600,
                        ]);
                        $res = json_decode((string) $response->getBody(),true);
                        if ($res['msg'] != 'success')
                            continue;
                        foreach ($res['result']['list'] as $item){
                            if (!Cook::getCookByMenuId($item['menuId'])){
                                if (!isset($item['recipe']['method']))
                                    continue;
                                $cook = Cook::create([
                                    'mob_ctg_ids' => $item['ctgIds'],
                                    'category_ids' => implode(',',Category::getCategoryIdsByMobCtgIds($item['ctgIds'])),
                                    'category_titles' => $item['ctgTitles'],
                                    'menu_id' => $item['menuId'],
                                    'title' => $item['name'],
                                    'img' => isset($item['recipe']['img']) ? $item['recipe']['img'] : '',
                                    'thumbnail' => isset($item['thumbnail']) ? $item['thumbnail'] : '',
                                    'introduction' => isset($item['recipe']['sumary']) ? $item['recipe']['sumary'] : $item['name'],
                                    'ingredients' => isset($item['recipe']['ingredients']) ? $item['recipe']['ingredients'] : '',
                                    'method' => $item['recipe']['method'],
                                    'source' => Cook::SOURCE_MOB
                                ]);
                                if ($cook){
                                    $this->info(str_repeat($fire,2).'菜谱：'.$cook->title.'【id='.$cook->id.'】创建成功。');
                                }else{
                                    $this->info('菜谱：'.$item['name'].'保存失败。');
                                }
                                unset($cook);
                            }
                        }
                        unset($res,$response,$client);
                    }catch (\Throwable $exception){
                        continue;
                    }
                    sleep(0.5);
                }
                unset($res,$response,$client);
            }
        }
    }
}
