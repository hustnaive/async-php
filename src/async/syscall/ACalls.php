<?php
namespace async\syscall;

class ACalls {
    
    static function invoke($_=[]) {
        $cb = new static;
        return call_user_func_array($cb, func_get_args());
    }
    
}