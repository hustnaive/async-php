<?php
namespace async\syscall;

class NewTask extends ACalls {
    
    function __invoke(\Generator $coroutine) {
        return new \async\SystemCall(
            function(\async\Task $task, \async\Scheduler $scheduler) use ($coroutine) {
                $task->setSendValue($scheduler->newTask($coroutine));
                $scheduler->schedule($task);
            }
        );
    }
}