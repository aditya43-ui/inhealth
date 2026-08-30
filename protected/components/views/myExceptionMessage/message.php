<?php
    $code = $exc->getCode();
    $file = $exc->getFile();
    $line = $exc->getLine();
    $message = $exc->getMessage();
    $traceString = $exc->getTraceAsString();
    $trace = $exc->getTrace();
    
    echo '<pre>'.print_r($trace).'</pre>';
?>
