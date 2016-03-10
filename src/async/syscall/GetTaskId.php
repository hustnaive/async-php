<?php
namespace async\syscall;

class GetTaskId extends ACalls {
    
    function __invoke() {
        return new \async\SystemCall(function(\async\Task $task, \async\Scheduler $scheduler) {
            $task->setSendValue($task->getTaskId());
            $scheduler->schedule($task);
        });
    }
}