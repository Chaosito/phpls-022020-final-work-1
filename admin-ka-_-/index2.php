<?php
require_once("../config.php");

$allUsers = FinalWork\User::getAllUsers();
$allOrders = FinalWork\Order::getAllOrders();

$usersBody = "";
foreach ($allUsers as $val) {
    $usersBody .= "<td>{$val['id']}</td><td>{$val['dt']}</td><td>{$val['first_name']}</td><td>{$val['mail']}</td>";
    $usersBody = '<tr>'.$usersBody.'</tr>';
}

$ordersBody = "";
foreach ($allOrders as $val) {
    $ordersBody .= "<td>{$val['id']}</td><td>{$val['dt']}</td><td>{$val['first_name']}</td><td>{$val['address']}</td>";
    $ordersBody = '<tr>'.$ordersBody.'</tr>';
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная страница
    </title>
    <link rel="stylesheet" href="../css/vendors.min.css">
    <link rel="stylesheet" href="../css/main.min.css">
</head>
<body>
<div class="wrapper">
    <div class="maincontent">
        <section class="section hero">
            <div class="container">
                <header class="header">
                    <div class="header__logo">
                        <a class="logo" href="/"><img class="logo__icon" src="../img/icons/logo.svg"></a>
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
                    <div class="hero__content" id="adminka-bg">
                        <table width="100%" border="1">
                            <thead>
                                <tr><th colspan="4">Список всех зарегистрированных пользователей</th></tr>
                                <tr>
                                    <th width="5%">#id</th>
                                    <th width="20%">Reg. date</th>
                                    <th width="20%">First name</th>
                                    <th>Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=$usersBody;?>
                            </tbody>
                        </table><br><br>
                        <table width="100%" border="1">
                            <thead>
                                <tr><th colspan="4">Список всех заказов</th></tr>
                                <tr>
                                    <th width="5%">#id</th>
                                    <th width="20%">Reg. date</th>
                                    <th width="20%">First name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=$ordersBody;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
<style>
    #adminka-bg {
        background-color: white;
        opacity:.8;
        min-height:300px;
        padding:10px;
        display: block;
    }
</style>
</html>
