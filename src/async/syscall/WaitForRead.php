<?php
namespace async\syscall;

class WaitForRead extends ACalls {
    
    function __invoke($socket) {
        return new \async\SystemCall(
            function(\async\Task $task, \async\Scheduler $scheduler) use ($socket) {
                $scheduler->waitForRead($socket, $task);
            }
        );
    }
}