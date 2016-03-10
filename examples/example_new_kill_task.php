<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

function childTask() {
    $tid = (yield \async\syscall\GetTaskId::invoke());
    while (true) {
        echo "Child task $tid still alive!\n";
        yield;
    }
}
 
function task() {
    $tid = (yield \async\syscall\GetTaskId::invoke());
    $childTid = (yield \async\syscall\NewTask::invoke(childTask()));
 
    for ($i = 1; $i <= 6; ++$i) {
        echo "Parent task $tid iteration $i.\n";
        yield;
 
        if ($i == 3) yield \async\syscall\KillTask::invoke($childTid);
    }
}
 
$scheduler = new \async\Scheduler;
$scheduler->newTask(task());
$scheduler->run();