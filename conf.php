<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

Flight::set('flight.base_url', '/');

$loader = new FilesystemLoader(__DIR__ . '/app/views');

$twig = new Environment($loader, [
    'cache' => __DIR__ . '/app/cache',
    'debug' => true,
]);

$twig->addGlobal('base_url', Flight::get('flight.base_url'));

Flight::map('render', function (string $template, array $data = []) use ($twig) {

    if (substr($template, -5) !== '.twig') {
        $template .= '.twig';
    }

    echo $twig->render($template, $data);
});

$twig->addFunction(
    new \Twig\TwigFunction('file_exists', 'file_exists')
);