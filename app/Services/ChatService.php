<?php
/**
 * Created by PhpStorm.
 * User: purelightme
 * Date: 2019/1/20
 * Time: 00:42
 */

namespace App\Services;


use App\Exceptions\UploadException;
use App\Tools\Upload\UploadTool;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class ChatService
{
    public $server;

    //发送消息类型
    const ACTION_LOGIN = 'login';
    const ACTION_MSG = 'msg';

    //回复消息类型
    const TYPE_COME = 'come';
    const TYPE_MSG = 'msg';
    const TYPE_LEAVE = 'leave';

    public function __construct($port)
    {
        $this->server = new Server('0.0.0.0',$port);
        $this->server->on('open', [$this,'onOpen']);
        $this->server->on('message', [$this,'onMessage']);
        $this->server->on('close', [$this,'onClose']);
//        $this->server->on('request', [$this,'onRequest']);
        $this->server->start();
    }

    public function onOpen(Server $server,Request $request)
    {
        $this->joinRoom($request->fd);
        $this->groupSend(self::TYPE_COME,[],'1位游客进入聊天室');
    }

    public function onMessage(Server $server,Frame $frame)
    {
        if ($frame->opcode == WEBSOCKET_OPCODE_BINARY){
            $this->handleBinaryMessage($frame);
        }
        if ($frame->opcode == WEBSOCKET_OPCODE_TEXT){
            $this->handleTextMessage($frame);
        }
    }

    /**
     * 处理二进制消息
     * @param Frame $frame
     */
    public function handleBinaryMessage(Frame $frame)
    {
        $upload = new UploadTool('public',80,'image');
        try {
            $path = $upload->uploadSingleFile($frame->data, '/chat/imgs');
        } catch (UploadException $e) {
            Log::error('聊天图片上传失败：'.$e->getMessage());
        }
        $this->groupSend(self::TYPE_MSG,$this->getUserInfo($frame->fd),[
            'action' => self::TYPE_MSG,
            'params' => [
                'img' => getImageUrl($path)
            ]
        ]);
    }

    /**
     * 处理文本消息
     * @param Frame $frame
     */
    public function handleTextMessage(Frame $frame)
    {
        list($fd,$data) = [$frame->fd,json_decode($frame->data,true)];
        if (!(is_array($data) && isset($data['action']) && isset($data['params']))){
            return;
        }
        switch ($data['action']){
            case self::ACTION_LOGIN:
                $res = $this->loginByAccessToken($fd,$data['params']['access_token']);
                if ($res)
                    $this->groupSend(self::TYPE_COME,$res,'');
                break;
            case self::ACTION_MSG:
                $this->groupSend(self::TYPE_MSG,$this->getUserInfo($fd),$data);
                break;
        }
    }

    public function onRequest(Request $request,Response $response)
    {
        //todo
    }

    public function onClose(Server $server,$fd)
    {
        $this->leaveRoom($fd);
        $userInfo = $this->getUserInfo($fd);
        if ($userInfo)
            $this->groupSend(self::TYPE_LEAVE,$userInfo,'',$fd);
//        else
//            $this->groupSend(self::TYPE_LEAVE,[],'',$fd);
    }

    /**
     * 加入房间
     * @param $fd
     * @param array $userInfo
     * @return mixed
     */
    public function joinRoom($fd,$userInfo = [])
    {
        if (!empty($userInfo) || !Redis::exists($fd))
            Redis::set($fd,json_encode($userInfo));
        return json_decode(Redis::get($fd),true);
    }

    /**
     * 登录
     * @param $fd
     * @param $accessToken
     * @return bool|mixed
     */
    public function loginByAccessToken($fd,$accessToken)
    {
        $client = new Client([
            'base_uri' => config('app.url'),
            'timeout' => 5
        ]);
        try {
            $response = $client->request('GET', '/user', [
                'headers' => [
                    'Authorization' => 'Bearer '.$accessToken
                ]
            ]);
        } catch (GuzzleException $e) {
            return false;
        }
        $res = json_decode((string)$response->getBody(),true);
        if ($res['errcode'] != 0)
            return false;
        return $this->joinRoom($fd,$res['data']);
    }

    /**
     * 群发消息
     * @param $action
     * @param $userInfo
     * @param string $msg
     */
    public function groupSend($action,$userInfo = [],$msg = '',$except = 0)
    {
        $fds = Redis::keys('*');
        foreach ($fds as $fd){
            if ($fd == $except)
                continue;
            if (!$this->server->isEstablished($fd))
                Redis::del($fd);
            else
                $this->server->push($fd,json_encode([
                    'action' => $action,
                    'params' => [
                        'user_info' => $userInfo,
                        'msg' => $msg
                    ]
                ]));
        }
    }

    /**
     * 获取在线人数
     * @return int
     */
    public function getOnlineCount()
    {
        return count(Redis::keys('*'));
    }

    /**
     * 获取客户端用户信息
     * @param $fd
     * @return mixed
     */
    public function getUserInfo($fd)
    {
        return json_decode(Redis::get($fd),true);
    }

    /**
     * 删除fd
     * @param $fd
     */
    public function leaveRoom($fd)
    {
        Redis::del($fd);
    }
}