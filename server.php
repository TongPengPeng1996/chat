<?php
use Workerman\Worker;
error_reporting(E_ALL & ~E_NOTICE);
require_once 'Workerman/Autoloader.php';

/**
 * msg
 * @access public
 * 转发客户端消息
 * @param  void
 * @param  void
 * @return void
 */
function msg($connection, $data)
{
	global $http;
	$data = htmlspecialchars($data);
	$data = addslashes($data);
	$cid  = (int) substr($data, 0, 1);
	$num  = (int) strpos($data, ':');
	if ($cid == 1)
	{
		$username = substr($data, 1, $num);
	}
	else
	{
		$username = substr($data, 0, $num);
	}
	$connection->uid = trim(str_replace(':', ' ', $username));
	$data = substr($data, strpos($data, ':'));
	if ($cid == 1)
	{
		$txt = $connection->uid . ' ';
		file_put_contents("user.php", $txt, FILE_APPEND);
	}
	// 1:表示执行登陆操作 2:表示执行说话操作 3:表示执行退出操作
	foreach ($http->connections as $conn)
	{
		$conn->send("{$connection->uid} 说 $data");
	}
}

/**
 * close
 * 关闭连接
 * @access public
 * @param  void
 * @return void
 */
function close($connection)
{
	global $http;
	$content = file_get_contents("user.php");
	$user = $connection->uid;
	$content = str_replace($user, '', $content);
	file_put_contents("user.php", $content);
	foreach ($http->connections as $conn)
	{
		if (!empty($connection->uid))
		{
			$conn->send("{$connection->uid} 退出");
		}
	}
}

// 创建一个Worker，使用http协议通讯
// $http = new Worker("websocket://0.0.0.0:9000");
$http = new Worker("websocket://0.0.0.0:8090");

// 启动10个进程对外提供服务
$http->count = 10;
// $http->onConnect = 'connect';
$http->onMessage = 'msg';
$http->onClose   = 'close';

// 运行worker
Worker::runAll();
