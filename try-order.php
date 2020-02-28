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

$name = (isset($_POST['name'])) ? strip_tags(trim($_POST['name'])) : '';
$phone = (isset($_POST['phone'])) ? strip_tags(trim($_POST['phone'])) : '';
$mail = (isset($_POST['email'])) ? strip_tags(trim($_POST['email'])) : '';
$street = (isset($_POST['street'])) ? strip_tags(trim($_POST['street'])) : '';
$home = (isset($_POST['home'])) ? strip_tags(trim($_POST['home'])) : '';
$part = (isset($_POST['part'])) ? strip_tags(trim($_POST['part'])) : '';
$appt = (isset($_POST['appt'])) ? strip_tags(trim($_POST['appt'])) : '';
$floor = (isset($_POST['floor'])) ? strip_tags(trim($_POST['floor'])) : '';
$comment = (isset($_POST['comment'])) ? strip_tags(trim($_POST['comment'])) : '';
$payment = (isset($_POST['payment'])) ? strip_tags(trim($_POST['payment'])) : '';
$callback = (isset($_POST['callback'])) ? (int)$_POST['callback'] : 0;

$uid = 333;
$addr = "Улица: {$street}, Дом: {$home}".
    (!empty($part) ? ", Корпус: {$part}" : "").
    (!empty($appt) ? ", Квартира: {$appt}" : "").
    (!empty($floor) ? ", Этаж: {$floor}" : "");

if ($payment == 'need_change') {
    $needChange = 1;
    $cardPayment = 0;
} elseif ($payment == 'card') {
    $needChange = 0;
    $cardPayment = 1;
} else {
    $needChange = 0;
    $cardPayment = 0;
}

if (!$curUser->isLogged() || $curUser->mail != $mail) {
    // register user
    $user = new User();

    try {
        $userId = $user->findByMail($mail);
    } catch (Exception $e) {
        die($e->getMessage());
    }

    if ($userId === false){
        $userId = $user->register($name, $phone, $mail, $street, $home, $part, $appt, $floor);
    } else {
        $curUser->updateInformation($userId, $name, $phone, $street, $home, $part, $appt, $floor);
    }
    $curUser->login($userId, $mail);
} else {
    $curUser->updateInformation($curUser->id, $name, $phone, $street, $home, $part, $appt, $floor);
}


$arrOrder = [$curUser->id, $addr, $comment, $needChange, $cardPayment, $callback];
DB::run("INSERT INTO orders (user_id, order_date, address, `comment`, need_change, card_payment, not_call) VALUES (?, NOW(), ?, ?, ?, ?, ?)", $arrOrder);
$orderId = DB::lastInsertId();

$ordersCnt = DB::run("SELECT COUNT(id) FROM orders WHERE user_id = ?", [$curUser->id])->fetchColumn();
$ordersCnt = ($ordersCnt == 1) ? "первый" : $ordersCnt;

$mailText = <<<EOT
Заказ №{$orderId}

DarkBeefBurger, 500 рублей, 1 шт.

Ваш заказ будет доставлен по адресу:
{$addr}

Спасибо - это ваш {$ordersCnt} заказ!
EOT;


mail($mail, "Заказ №{$orderId}", $mailText);
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
                    <div class="header__logo"><a class="logo" href="/"><img class="logo__icon" src="./img/icons/logo.svg"></a></div>
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
                    <div class="header__links"><a class="order-link btn" href="/index.php#link-lets-order">Заказать</a><a class="hamburger-menu-link" href="">
                            <div class="hamburger-menu-link__bars"></div></a></div>
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
