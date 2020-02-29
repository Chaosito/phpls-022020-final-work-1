<?php
// Базовая конфигурация и автолоад;
@session_start(); // Запускаем сессию

mb_internal_encoding("UTF-8");  // Кодировка
date_default_timezone_set('Asia/Almaty'); // Часовой пояс

spl_autoload_register(function ($classname) {
    $file = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."{$classname}.php";
    if (file_exists($file)) {
        require_once($file);
    }
});

$curUser = new FinalWork\CurrentUser();
