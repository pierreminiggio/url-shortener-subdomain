<?php

$httpHost = $_SERVER['HTTP_HOST'];
$explodedHttpHost = explode('.', $httpHost, 2);

if (count($explodedHttpHost) !== 2) {
    http_response_code(500);
    exit;
}

$userSlug = $explodedHttpHost[0];
$newHttpHost = $explodedHttpHost[1];

$_SERVER['HTTP_HOST'] = $newHttpHost;
$_SERVER['REQUEST_URI'] = '/' . $userSlug . $_SERVER['REQUEST_URI'];

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'ggio' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'index.php';
