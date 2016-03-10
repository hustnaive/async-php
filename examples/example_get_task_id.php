<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

function task($max) {
    $tid = (yield async\syscall\GetTaskId::invoke()); // <-- here's the syscall!
    for ($i = 1; $i <= $max; ++$i) {
        echo "This is task $tid iteration $i.\n";
        yield;
    }
}
 
$scheduler = new async\Scheduler;
 
$scheduler->newTask(task(1));
$scheduler->newTask(task(5));
 
$scheduler->run();
