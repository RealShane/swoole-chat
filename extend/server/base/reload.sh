
#!/bin/bash
count=`ps -fe |grep "SwooleMaster" | grep -v "grep" | grep "master" | wc -l`
time=$(date +%Y-%m-%d_%H:%M:%S)
echo "$time 本次count值为：$count   " >>/www/wwwroot/apptest.huihuagongxue.top/swoole-chat/extend/server/base/sh.log
if [ $count -lt 7 ]
then
{
ps -eaf |grep "SwooleMaster" | grep -v "grep"| awk '{print $2}'|xargs kill -9
sleep 2
ulimit -c unlimited
nohup php /www/wwwroot/apptest.huihuagongxue.top/swoole-chat/extend/server/base/WS.php > /www/wwwroot/apptest.huihuagongxue.top/swoole-chat/extend/server/base/note.log &
echo "$time Swoole服务挂了,目前已重启" >>/www/wwwroot/apptest.huihuagongxue.top/swoole-chat/extend/server/base/sh.log
}
else
{
 echo "$time : 9502端口正常" >>/www/wwwroot/apptest.huihuagongxue.top/swoole-chat/extend/server/base/sh.log
}
fi