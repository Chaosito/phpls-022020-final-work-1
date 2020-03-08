<?php
include_once('config.php');
echo $twig->render('index.twig', ['user' => $curUser]);
