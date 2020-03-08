<?php

/*
  Класс Settings
  Настройки сайта
*/

namespace FinalWork;

class Settings
{
    const DEBUG_MODE = true;
    const COOKIE_LIFE_TIME = 604800; // 7 Дней = (7 * 24 * 3600)

    /* MySQL Connection */
    const MYSQL_HOST = 'localhost';
    const MYSQL_USER = 'burgers';
    const MYSQL_PASS = '8urger5';
    const MYSQL_DB   = 'burgers';
    const MYSQL_CHAR = 'utf8';

    /* Mail-Server (for send messages) */
    const MAIL_SERVER       = 'smtp.yandex.ru';
    const MAIL_PORT         = 465;
    const MAIL_USER         = '***USER***';
    const MAIL_PASS         = '***PASSWORD***';
    const MAIL_ENCRYPTION   = 'SSL';
    const MAIL_FROM_NAME    = 'Burgers';
}
