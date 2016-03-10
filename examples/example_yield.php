<?php
function gen() {
    while(true) {
        $ret = (yield 'yield1');
        var_dump(__FUNCTION__." ".$ret);
        $ret = (yield 'yield2');
        var_dump(__FUNCTION__." ".$ret);
    }
}
 
$gen = gen();
for($i=0;$i<10;$i++) {
    var_dump($i.'='.$gen->current());
    var_dump($gen->send($i));
}
var_dump($gen->valid());