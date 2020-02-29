<?php

require_once("config.php");

if (isset($_REQUEST['logout'])) {
    $curUser->logout();
    header('Location: index.php#link-lets-order');
    exit;
}

if (!isset($_POST['email'])) {
    header('Location: index.php');
    exit;
}

$formData = new FormData();
$user = new User();

/*
 * Если пользак не авторизован по сессии или кукам или текущая переданная почта не соответствует почте авторизованного:
 * Проверим есть ли он в БД по переданному Email
 * Если есть то логиним (пишем сессию и куку) и обновляем инфу по нему (адрес, итд)
 * Если нет то регаем и логиним (пишем сессию и куку)
 */
if (!$curUser->isLogged() || $curUser->mail != $formData->mail) {
    $userExists = $user->findUserBy('mail', $formData->mail);
    if ($userExists) {
        $curUser->login($user->id, $user->mail);
        $curUser->updateInformation($formData);
    } else {
        $userId = $user->register($formData);
        $curUser->login($userId, $formData->mail);
    }
} else {
    $curUser->updateInformation($formData);
}

$objOrder = new Order($curUser);
$orderId = $objOrder->createOrder($formData);

if (!$orderId) {
    // error, unknown error
    die('Во время заказа произошла ошибка, попробуйте позже!');
}

$ordersByThisUser = $curUser->getOrdersCount();
$ordersByThisUser = ($ordersByThisUser == 1) ? "первый" : $ordersByThisUser;

$mailText = <<<EOT
Заказ №{$orderId}

DarkBeefBurger, 500 рублей, 1 шт.

Ваш заказ будет доставлен по адресу:
{$objOrder->address}

Спасибо - это ваш {$ordersByThisUser} заказ!
EOT;

mail($curUser->mail, "Заказ №{$orderId}", $mailText);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная страница
    </title>
    <link rel="stylesheet" href="./css/vendors.min.css">
    <link rel="stylesheet" href="./css/main.min.css">
</head>
<body>
<div class="wrapper">
    <div class="maincontent">
        <section class="section hero">
            <div class="container">
                <header class="header">
                    <div class="header__logo">
                        <a class="logo" href="/"><img class="logo__icon" src="./img/icons/logo.svg"></a>
                    </div>
                    <div class="header__menu">
                        <nav class="nav">
                            <ul class="nav__list">
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-about">о нас</a>
                                </li>
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-burgers">бургеры</a>
                                </li>
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-team">команда</a>
                                </li>
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-menu">меню</a>
                                </li>
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-reviews">отзывы</a>
                                </li>
                                <li class="nav__item"><a class="nav__link" href="/index.php#link-map">контакты</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__links">
                        <a class="order-link btn" href="/index.php#link-lets-order">Заказать</a>
                        <a class="hamburger-menu-link" href=""><div class="hamburger-menu-link__bars"></div></a>
                    </div>
                </header>
                <div class="hero__container">
                    <div class="hero__content">
                        <div class="hero__left"><img class="hero__img" src="./img/content/burger.png" alt=""></div>
                        <div class="hero__right">
                            <div class="section__title" style="color:#00C832">Заказ принят</div>
                            <div class="hero__desc">Мы доставим его в течении часа</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
