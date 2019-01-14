<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ImportCategoryFromJisu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-category:jisu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从极速api拉取分类,补充到数据库';

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
        $categories = <<<CATEGORY
        [
{
    "classid": "223",
    "name": "菜系",
    "parentid": "0",
    "list": [
        {
            "classid": "224",
            "name": "川菜",
            "parentid": "223"
        },
        {
            "classid": "225",
            "name": "湘菜",
            "parentid": "223"
        },
        {
            "classid": "226",
            "name": "粤菜",
            "parentid": "223"
        },
        {
            "classid": "227",
            "name": "闽菜",
            "parentid": "223"
        },
        {
            "classid": "228",
            "name": "浙菜",
            "parentid": "223"
        },
        {
            "classid": "229",
            "name": "鲁菜",
            "parentid": "223"
        },
        {
            "classid": "230",
            "name": "苏菜",
            "parentid": "223"
        },
        {
            "classid": "231",
            "name": "徽菜",
            "parentid": "223"
        },
        {
            "classid": "232",
            "name": "京菜",
            "parentid": "223"
        },
        {
            "classid": "233",
            "name": "天津菜",
            "parentid": "223"
        },
        {
            "classid": "234",
            "name": "上海菜",
            "parentid": "223"
        },
        {
            "classid": "235",
            "name": "渝菜",
            "parentid": "223"
        },
        {
            "classid": "236",
            "name": "东北菜",
            "parentid": "223"
        },
        {
            "classid": "237",
            "name": "清真菜",
            "parentid": "223"
        },
        {
            "classid": "238",
            "name": "豫菜",
            "parentid": "223"
        },
        {
            "classid": "239",
            "name": "晋菜",
            "parentid": "223"
        },
        {
            "classid": "240",
            "name": "赣菜",
            "parentid": "223"
        },
        {
            "classid": "241",
            "name": "湖北菜",
            "parentid": "223"
        },
        {
            "classid": "242",
            "name": "云南菜",
            "parentid": "223"
        },
        {
            "classid": "243",
            "name": "贵州菜",
            "parentid": "223"
        },
        {
            "classid": "244",
            "name": "新疆菜",
            "parentid": "223"
        },
        {
            "classid": "245",
            "name": "淮扬菜",
            "parentid": "223"
        },
        {
            "classid": "246",
            "name": "潮州菜",
            "parentid": "223"
        },
        {
            "classid": "247",
            "name": "客家菜",
            "parentid": "223"
        },
        {
            "classid": "248",
            "name": "广西菜",
            "parentid": "223"
        },
        {
            "classid": "249",
            "name": "西北菜",
            "parentid": "223"
        },
        {
            "classid": "250",
            "name": "香港美食",
            "parentid": "223"
        },
        {
            "classid": "251",
            "name": "台湾菜",
            "parentid": "223"
        },
        {
            "classid": "252",
            "name": "澳门美食",
            "parentid": "223"
        },
        {
            "classid": "253",
            "name": "西餐",
            "parentid": "223"
        },
        {
            "classid": "254",
            "name": "日本料理",
            "parentid": "223"
        },
        {
            "classid": "255",
            "name": "韩国料理",
            "parentid": "223"
        },
        {
            "classid": "256",
            "name": "泰国菜",
            "parentid": "223"
        },
        {
            "classid": "257",
            "name": "越南菜",
            "parentid": "223"
        },
        {
            "classid": "258",
            "name": "意大利菜",
            "parentid": "223"
        },
        {
            "classid": "259",
            "name": "墨西哥菜",
            "parentid": "223"
        },
        {
            "classid": "260",
            "name": "西班牙菜",
            "parentid": "223"
        },
        {
            "classid": "261",
            "name": "法国菜",
            "parentid": "223"
        },
        {
            "classid": "262",
            "name": "美国菜",
            "parentid": "223"
        },
        {
            "classid": "263",
            "name": "巴西烧烤",
            "parentid": "223"
        },
        {
            "classid": "264",
            "name": "东南亚菜",
            "parentid": "223"
        },
        {
            "classid": "265",
            "name": "印度菜",
            "parentid": "223"
        },
        {
            "classid": "266",
            "name": "伊朗菜",
            "parentid": "223"
        },
        {
            "classid": "267",
            "name": "土耳其菜",
            "parentid": "223"
        },
        {
            "classid": "268",
            "name": "澳大利亚菜",
            "parentid": "223"
        }
    ]
},
{
            "classid": "269",
            "name": "小吃",
            "parentid": "0",
            "list": [
                {
                    "classid": "270",
                    "name": "北京小吃",
                    "parentid": "269"
                },
                {
                    "classid": "271",
                    "name": "上海小吃",
                    "parentid": "269"
                },
                {
                    "classid": "272",
                    "name": "天津小吃",
                    "parentid": "269"
                },
                {
                    "classid": "273",
                    "name": "四川小吃",
                    "parentid": "269"
                },
                {
                    "classid": "274",
                    "name": "成都小吃",
                    "parentid": "269"
                },
                {
                    "classid": "275",
                    "name": "南京小吃",
                    "parentid": "269"
                },
                {
                    "classid": "276",
                    "name": "浙江小吃",
                    "parentid": "269"
                },
                {
                    "classid": "277",
                    "name": "苏州小吃",
                    "parentid": "269"
                },
                {
                    "classid": "278",
                    "name": "长沙小吃",
                    "parentid": "269"
                },
                {
                    "classid": "279",
                    "name": "湖北小吃",
                    "parentid": "269"
                },
                {
                    "classid": "280",
                    "name": "武汉小吃",
                    "parentid": "269"
                },
                {
                    "classid": "281",
                    "name": "广东小吃",
                    "parentid": "269"
                },
                {
                    "classid": "282",
                    "name": "广州小吃",
                    "parentid": "269"
                },
                {
                    "classid": "283",
                    "name": "潮汕小吃",
                    "parentid": "269"
                },
                {
                    "classid": "284",
                    "name": "广西小吃",
                    "parentid": "269"
                },
                {
                    "classid": "285",
                    "name": "陕西小吃",
                    "parentid": "269"
                },
                {
                    "classid": "286",
                    "name": "西安小吃",
                    "parentid": "269"
                },
                {
                    "classid": "287",
                    "name": "新疆小吃",
                    "parentid": "269"
                },
                {
                    "classid": "288",
                    "name": "开封小吃",
                    "parentid": "269"
                },
                {
                    "classid": "289",
                    "name": "云南小吃",
                    "parentid": "269"
                },
                {
                    "classid": "290",
                    "name": "贵州小吃",
                    "parentid": "269"
                },
                {
                    "classid": "291",
                    "name": "台湾小吃",
                    "parentid": "269"
                },
                {
                    "classid": "292",
                    "name": "香港小吃",
                    "parentid": "269"
                },
                {
                    "classid": "293",
                    "name": "澳门小吃",
                    "parentid": "269"
                },
                {
                    "classid": "294",
                    "name": "河南小吃",
                    "parentid": "269"
                },
                {
                    "classid": "295",
                    "name": "青岛小吃",
                    "parentid": "269"
                },
                {
                    "classid": "296",
                    "name": "沙县小吃",
                    "parentid": "269"
                },
                {
                    "classid": "297",
                    "name": "厦门小吃",
                    "parentid": "269"
                },
                {
                    "classid": "298",
                    "name": "山西小吃",
                    "parentid": "269"
                },
                {
                    "classid": "299",
                    "name": "重庆小吃",
                    "parentid": "269"
                },
                {
                    "classid": "300",
                    "name": "海南小吃",
                    "parentid": "269"
                }
            ]
        },
        {
            "classid": "561",
            "name": "场景",
            "parentid": "0",
            "list": [
                {
                    "classid": "562",
                    "name": "早餐",
                    "parentid": "561"
                },
                {
                    "classid": "563",
                    "name": "午餐",
                    "parentid": "561"
                },
                {
                    "classid": "564",
                    "name": "下午茶",
                    "parentid": "561"
                },
                {
                    "classid": "565",
                    "name": "晚餐",
                    "parentid": "561"
                },
                {
                    "classid": "566",
                    "name": "夜宵",
                    "parentid": "561"
                },
                {
                    "classid": "567",
                    "name": "野餐",
                    "parentid": "561"
                },
                {
                    "classid": "568",
                    "name": "聚会",
                    "parentid": "561"
                },
                {
                    "classid": "569",
                    "name": "踏青",
                    "parentid": "561"
                },
                {
                    "classid": "570",
                    "name": "单身",
                    "parentid": "561"
                },
                {
                    "classid": "571",
                    "name": "二人世界",
                    "parentid": "561"
                },
                {
                    "classid": "572",
                    "name": "宴请",
                    "parentid": "561"
                },
                {
                    "classid": "573",
                    "name": "熬夜",
                    "parentid": "561"
                },
                {
                    "classid": "574",
                    "name": "春节",
                    "parentid": "561"
                },
                {
                    "classid": "575",
                    "name": "情人节",
                    "parentid": "561"
                },
                {
                    "classid": "576",
                    "name": "元宵节",
                    "parentid": "561"
                },
                {
                    "classid": "577",
                    "name": "二月二",
                    "parentid": "561"
                },
                {
                    "classid": "578",
                    "name": "复活节",
                    "parentid": "561"
                },
                {
                    "classid": "579",
                    "name": "愚人节",
                    "parentid": "561"
                },
                {
                    "classid": "580",
                    "name": "寒食节",
                    "parentid": "561"
                },
                {
                    "classid": "581",
                    "name": "清明节",
                    "parentid": "561"
                },
                {
                    "classid": "582",
                    "name": "三月三",
                    "parentid": "561"
                },
                {
                    "classid": "583",
                    "name": "母亲节",
                    "parentid": "561"
                },
                {
                    "classid": "584",
                    "name": "儿童节",
                    "parentid": "561"
                },
                {
                    "classid": "585",
                    "name": "端午节",
                    "parentid": "561"
                },
                {
                    "classid": "586",
                    "name": "父亲节",
                    "parentid": "561"
                },
                {
                    "classid": "587",
                    "name": "六月六",
                    "parentid": "561"
                },
                {
                    "classid": "588",
                    "name": "七夕节",
                    "parentid": "561"
                },
                {
                    "classid": "589",
                    "name": "中元节",
                    "parentid": "561"
                },
                {
                    "classid": "590",
                    "name": "中秋节",
                    "parentid": "561"
                },
                {
                    "classid": "591",
                    "name": "重阳节",
                    "parentid": "561"
                },
                {
                    "classid": "592",
                    "name": "万圣节",
                    "parentid": "561"
                },
                {
                    "classid": "593",
                    "name": "感恩节",
                    "parentid": "561"
                },
                {
                    "classid": "594",
                    "name": "圣诞节",
                    "parentid": "561"
                },
                {
                    "classid": "595",
                    "name": "腊八节",
                    "parentid": "561"
                },
                {
                    "classid": "596",
                    "name": "小年",
                    "parentid": "561"
                },
                {
                    "classid": "597",
                    "name": "年夜饭",
                    "parentid": "561"
                },
                {
                    "classid": "598",
                    "name": "春季",
                    "parentid": "561"
                },
                {
                    "classid": "599",
                    "name": "夏季",
                    "parentid": "561"
                },
                {
                    "classid": "600",
                    "name": "秋季",
                    "parentid": "561"
                },
                {
                    "classid": "601",
                    "name": "冬季",
                    "parentid": "561"
                },
                {
                    "classid": "602",
                    "name": "立春",
                    "parentid": "561"
                },
                {
                    "classid": "603",
                    "name": "雨水",
                    "parentid": "561"
                },
                {
                    "classid": "604",
                    "name": "惊蛰",
                    "parentid": "561"
                },
                {
                    "classid": "605",
                    "name": "春分",
                    "parentid": "561"
                },
                {
                    "classid": "606",
                    "name": "清明",
                    "parentid": "561"
                },
                {
                    "classid": "607",
                    "name": "谷雨",
                    "parentid": "561"
                },
                {
                    "classid": "608",
                    "name": "立夏",
                    "parentid": "561"
                },
                {
                    "classid": "609",
                    "name": "小满",
                    "parentid": "561"
                },
                {
                    "classid": "610",
                    "name": "芒种",
                    "parentid": "561"
                },
                {
                    "classid": "611",
                    "name": "夏至",
                    "parentid": "561"
                },
                {
                    "classid": "612",
                    "name": "小暑",
                    "parentid": "561"
                },
                {
                    "classid": "613",
                    "name": "大暑",
                    "parentid": "561"
                },
                {
                    "classid": "614",
                    "name": "立秋",
                    "parentid": "561"
                },
                {
                    "classid": "615",
                    "name": "处暑",
                    "parentid": "561"
                },
                {
                    "classid": "616",
                    "name": "白露",
                    "parentid": "561"
                },
                {
                    "classid": "617",
                    "name": "秋分",
                    "parentid": "561"
                },
                {
                    "classid": "618",
                    "name": "寒露",
                    "parentid": "561"
                },
                {
                    "classid": "619",
                    "name": "霜降",
                    "parentid": "561"
                },
                {
                    "classid": "620",
                    "name": "立冬",
                    "parentid": "561"
                },
                {
                    "classid": "621",
                    "name": "小雪",
                    "parentid": "561"
                },
                {
                    "classid": "622",
                    "name": "大雪",
                    "parentid": "561"
                },
                {
                    "classid": "623",
                    "name": "冬至",
                    "parentid": "561"
                },
                {
                    "classid": "624",
                    "name": "小寒",
                    "parentid": "561"
                },
                {
                    "classid": "625",
                    "name": "大寒",
                    "parentid": "561"
                }
            ]
        }
        ]
CATEGORY;
        $categories = json_decode($categories,true);
        foreach ($categories as $root){
            $rootCategory = Category::getCategoryByName('按'.$root['name'].'选择菜谱');
            if (!$rootCategory){
                $rootCategory = Category::create([
                    'parent_id' => Category::where('parent_id',0)->first()->id,
                    'title' => '按'.$root['name'].'选择菜谱',
                ]);
            }
            foreach ($root['list'] as $second){
                $secondCategory = Category::getCategoryByName($second['name']);
                if ($secondCategory){
                    $secondCategory->update(['jisu_class_id' => $secondCategory['classid']]);
                }else{
                    if (Category::create([
                        'parent_id' => $rootCategory->id,
                        'title' => $second['name'],
                        'jisu_class_id' => $second['classid']
                    ])){
                        $this->info('成功创建分类：'.$second['name']);
                    }
                }
            }
        }
    }
}
