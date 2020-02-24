<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel;


$request = Request::createFromGlobals();
$routes = include __DIR__ . '/routes.php';
$container = include __DIR__ . '/container.php';

$framework = $container['framework'];
$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__ . '/../cache'),
    new HttpKernel\HttpCache\Esi(),
    ['debug' => false]
);

$framework->handle($request)->send();