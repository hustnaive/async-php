<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

function server($port) {
    echo "Starting server at port $port...\n";
 
    $socket = @stream_socket_server("tcp://localhost:$port", $errNo, $errStr);
    if (!$socket) throw new Exception($errStr, $errNo);
 
    stream_set_blocking($socket, 0);
 
    while (true) {
        yield \async\syscall\WaitForRead::invoke($socket); //系统调用，等待IO读
        $clientSocket = stream_socket_accept($socket, 0);
        yield \async\syscall\NewTask::invoke(handleClient($clientSocket));
    }
}
 
function handleClient($socket) {
    yield \async\syscall\WaitForRead::invoke($socket); //系统调用，等待IO读
    $data = fread($socket, 8192);
 
    $msg = "Received following request:\n\n$data";
    $msgLength = strlen($msg);
 
    $response = <<<RES
HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\nContent-Length: $msgLength\r\nConnection: close\r\n\r\n$msg
RES;
    echo $response;
    yield \async\syscall\WaitForWrite::invoke($socket); //系统调用，等待IO写
    fwrite($socket, $response);
    
    fclose($socket);
}
 
$scheduler = new \async\Scheduler;
$scheduler->newTask(server(8000));
$scheduler->newTask($scheduler->ioPollTask());
$scheduler->run();