<?php
declare (strict_types = 1);

namespace app\listener;

use app\Request;
use Swoole\Server;
use think\Container;
use think\swoole\Table;
use think\swoole\Websocket;

class WebSocketEvent
{
    protected $websocket = null;
    protected $server = null;
    protected $table = null;
    protected $u2fd = null;
    protected $fd2u = null;


    /**
     * WebSocketEvent constructor.
     * @param Server $server server对象
     * @param Websocket $websocket websocket对线
     * @param Container $container 容器
     */
    public function __construct(Server $server, Websocket $websocket, Container $container)
    {
        //这里取对象的方式有很多种,看个人习惯,在此列举其中几种方式
        $this->websocket = $websocket;//依赖注入的方式
        $this->server = $server;
        //think\table对象
        $this->table = $container->get(Table::class);//从容器中取
        //在think\Table的配置章节配置了两个table,使用方式如下
        //vendor\topthink\think-swoole\src\Table.php实现了__get魔术方法,因此直接table->表即可使用
        //或者table->get(表名)取得该表
        $this->u2fd = $this->table->u2fd;
        $this->fd2u = $this->table->fd2u;
    }

    public function onConnect(Request $request)
    {
        //onOpen触发的事件,传入的是一个request对象

        //模拟产生一个用户编号
        $uid = rand(100, 999);
        //将uid与fd用table进行关联,set方法的key必须为string类型
        //通过websocket的上下文取得fd:$this->websocket->getSender()
        $this->table->u2fd->set((string)$uid, ['fd' => $this->websocket->getSender()]);
        //将fd与uid用table进行关联
        //注意传入数组的key必须与tables中的columns的name值相同,否则无法写入
        $this->table->fd2u->set((string)$this->websocket->getSender(), ['uid' => $uid]);
        //这里是对所有的连接发送一次广播,消息为online,当前连接用户的uid,在线数量,当前连接用户的fd值
        foreach ($this->table->u2fd as $row) {
            $this->server->push($row['fd'], json_encode(['msg' => 'online', 'uid' => $uid, 'online_count' => $this->u2fd->count(), 'fd' => $this->websocket->getSender()], 320));
        }
    }

    public function onClose()
    {
        //onClose触发的事件

        //将离线的用户从关系表中移除
        $uid = $this->table->fd2u->get((string)$this->websocket->getSender(), 'uid');
        //注意传入参数必须为string类型
        $this->table->u2fd->del((string)$uid);
        $this->table->fd2u->del((string)$this->websocket->getSender());
        //广播下线
        foreach ($this->table->u2fd as $row) {
            $this->server->push($row['fd'], json_encode(['msg' => 'offline', 'uid' => $uid, 'online_count' => $this->u2fd->count(), 'fd' => $this->websocket->getSender()], 320));
        }
    }

    public function onPoint($event)
    {
        //点对点消息 即json中event值为point会触发该方法
        //json:{"event":"point","data":{"to":uid,"content":"wsmsg"}}

        //用uid从列表中查找该用户是否在线
        $toFd = $this->table->u2fd->get((string)$event['to'], 'fd');
        if ($toFd === false) {
            if (isset($event['api'])) {
                return 'offlone';
            }
            $this->server->push($this->websocket->getSender(), $event['to'] . ' is not online');
        }
        //判断是否来自api消息
        if (isset($event['api'])) {
            //消息下放
            $this->server->push($toFd, $this->assemblyData('point', ['sender' => $event['uid'] ?? 0, 'content' => $event['content']]));
        } else {
            //消息下放
            $this->server->push($toFd, $this->assemblyData('point', ['sender' => $this->table->fd2u->get((string)$this->websocket->getSender(), 'uid'), 'content' => $event['content']]));
        }

    }

    public function onPing()
    {
        //响应ping消息
        //{"event":"ping","data":""}
        $this->server->push($this->websocket->getSender(), $this->assemblyData('pong', []));
    }

    //more event function

    //统一的消息格式
    protected function assemblyData(string $event, array $data, int $code = 0): string
    {
        return json_encode(['event' => $event, 'data' => $data, 'code' => $code], 320);
    }
}
