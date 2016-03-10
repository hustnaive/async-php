<?php
namespace async\syscall;

class WaitForWrite extends ACalls {
    
    function __invoke($socket) {
        return new \async\SystemCall(
            function(\async\Task $task, \async\Scheduler $scheduler) use ($socket) {
                $scheduler->waitForWrite($socket, $task);
            }
        );
    }
}