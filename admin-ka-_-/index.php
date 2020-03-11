<?php
namespace FinalWork;

require_once("../config.php");

$allUsers = User::getAllUsers();
$allOrders = Order::getAllOrders();

echo $twig->render('admin.twig', ['allUsers' => $allUsers, 'allOrders' => $allOrders]);