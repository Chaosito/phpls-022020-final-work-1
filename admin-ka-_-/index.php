<?php
require_once("../config.php");

$allUsers = FinalWork\User::getAllUsers();
$allOrders = FinalWork\Order::getAllOrders();

echo $twig->render('admin.twig', ['allUsers' => $allUsers, 'allOrders' => $allOrders]);
