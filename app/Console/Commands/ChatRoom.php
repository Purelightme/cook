<?php

namespace App\Console\Commands;

use App\Services\ChatService;
use Illuminate\Console\Command;

class ChatRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chart:start {--port=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开启聊天室';

    protected $help = <<<HELP
用法：php artisan chart:start --port=
示例：php artisan chart:start --port=6379

该命令将在port指定的端口开启websocket服务...host默认为：0.0.0.0
HELP;


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
        $port = $this->options()['port'];
        if (!$port){
            $this->error($this->help);return;
        }
        $this->info('Websocket service will listen at ws://0.0.0.0:4396');
        new ChatService($port);
    }
}
