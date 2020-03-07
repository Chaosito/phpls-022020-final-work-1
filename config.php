<?php
// Базовая конфигурация и автолоад;
@session_start(); // Запускаем сессию

mb_internal_encoding("UTF-8");  // Кодировка
date_default_timezone_set('Asia/Almaty'); // Часовой пояс

include_once('vendor/autoload.php');

$curUser = new FinalWork\CurrentUser();
