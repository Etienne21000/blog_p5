<?php
require_once (__DIR__ .'/vendor/autoload.php');

$title_name = "Site web d'Etienne Juffard";

$title = array(
    'name' => $title_name,
);

$loader = new \Twig\Loader\FilesystemLoader('./src/View/Template');
$twig = new \Twig\Environment($loader);
$twig->addGlobal("title", $title);

$template = $twig->load('base.html.twig');

echo $twig->render('home.html.twig');
