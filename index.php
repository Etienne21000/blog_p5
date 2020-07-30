<?php
require_once (__DIR__ .'/vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('./src/View/Template');
$twig = new \Twig\Environment($loader, [
    'cache' => '%kernel.cache_dir%/twig',
]);

$template = $twig->load('base.html.twig');

$twig->render('home.html.twig');
