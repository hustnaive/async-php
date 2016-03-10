<?php
namespace async\syscall;

class KillTask extends ACalls {
    
    function __invoke($tid) {
        return new \async\SystemCall(
            function(\async\Task $task, \async\Scheduler $scheduler) use ($tid) {
                $task->setSendValue($scheduler->killTask($tid));
                $scheduler->schedule($task);
            }
        );
    }
}