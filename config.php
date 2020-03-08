<?php
// Базовая конфигурация и автолоад;
@session_start(); // Запускаем сессию

mb_internal_encoding("UTF-8");  // Кодировка
date_default_timezone_set('Asia/Almaty'); // Часовой пояс

include_once('vendor/autoload.php');

$curUser = new FinalWork\CurrentUser();

//---twig
$path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'main';
$loader = new \Twig\Loader\FilesystemLoader($path);

$twig = new \Twig\Environment($loader, [
    // 'debug' => true,
   ['cache' => $path . '_cache', 'autoescape' => false]
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
