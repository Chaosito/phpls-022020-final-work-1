<?php
namespace FinalWork;

require_once("../config.php");

echo $twig->render('admin.twig', ['allUsers' => $allUsers, 'allOrders' => $allOrders]);