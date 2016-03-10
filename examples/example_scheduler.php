<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

function task1() {
    for ($i = 1; $i <= 10; ++$i) {
        echo "This is task 1 iteration $i.\n";
        yield;
    }
}

function task2() {
    for ($i = 1; $i <= 5; ++$i) {
        echo "This is task 2 iteration $i.\n";
        yield;
    }
}

$scheduler = new \fangl\async\Scheduler;

$scheduler->newTask(task1());
$scheduler->newTask(task2());

$scheduler->run();