<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Cook;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ImportCategoryCookFromJisu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-cook:jisu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从极速api拉取分类菜谱';

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
        $pageSize = 500;
        $url = 'http://api.jisuapi.com/recipe/byclass';
        $categories = Category::where('jisu_class_id', '<>', "")
            ->whereNotNull('jisu_class_id')
            ->get();
        foreach ($categories as $category) {
            for ($i = 0; ; $i++) {
                try {
                    $client = new Client();
                    $response = $client->request('GET', $url, [
                        'query' => [
                            'classid' => $category->jisu_class_id,
                            'start' => $i * $pageSize,
                            'num' => $pageSize,
                            'appkey' => config('cook.jisu.appKey')
                        ],
                        'connect_timeout' => 3600,
                    ]);
                    $res = json_decode((string)$response->getBody(), true);
                    if ($res['status'] != 0) {
                        break;
                    }
                    //保存数据
                    foreach ($res['result']['list'] as $item) {
                        $category = Category::getCategoryByJisuClassId($item['classid']);
                        $methods = [];
                        foreach ($item['process'] as $process){
                            $methods[] = [
                                'img' => $process['pic'],
                                'step' => $process['pcontent']
                            ];
                        }
                        $cook = Cook::create([
                            'category_ids' => implode(',',[$category->id]),
                            'category_titles' => implode(',',[$category->title]),
                            'title' => $item['name'],
                            'img' => isset($item['pic']) ? $item['pic'] : '',
                            'thumbnail' => isset($item['thumbnail']) ? $item['thumbnail'] : '',
                            'introduction' => isset($item['content']) ? $item['content'] : $item['name'],
                            'ingredients' => isset($item['material']) ? json_encode($item['material']) : '',
                            'method' => $methods,
                            'source' => Cook::SOURCE_JISU
                        ]);
                        if ($cook) {
                            $this->info(str_repeat($fire, 1) . '菜谱：' . $cook->title . '【id=' . $cook->id . '】创建成功。');
                        } else {
                            $this->info('菜谱：' . $item['name'] . '保存失败。');
                        }
                    }
                    unset($client,$response,$res);
                } catch (\Throwable $e) {
                    $this->error('请求出错了：'.$e->getMessage());
                    continue;
                }
            }
        }
        $this->info('导入完成');
    }
}
