<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel;
use Providers\EventSubscriptionProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$request = Request::createFromGlobals();
$routes = include __DIR__ . '/routes.php';
$container = include __DIR__ . '/container.php';

(new EventSubscriptionProvider($container['dispatcher']))->start();

$loader = new FilesystemLoader(__DIR__ . '/pages');
$twig = new Environment($loader);

//echo $twig->render('test.html', ['test' => 'Albert']);

$framework = $container['framework'];
$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__ . '/../cache'),
    new HttpKernel\HttpCache\Esi(),
    ['debug' => false]
);

$framework->handle($request)->send();