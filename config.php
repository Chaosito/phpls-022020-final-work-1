<?php

// Базовая конфигурация и автолоад;
define('ROOT_PATH', dirname(__FILE__));

@session_start(); // Запускаем сессию

mb_internal_encoding("UTF-8");  // Кодировка
date_default_timezone_set('Asia/Almaty'); // Часовой пояс

function includeClasses($classname){
    $file = ROOT_PATH.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."{$classname}.php";
    if (file_exists($file)) require_once($file);
}
spl_autoload_register('includeClasses');

$curUser = new CurrentUser();
