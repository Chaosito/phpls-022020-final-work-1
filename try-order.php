<?php
namespace FinalWork;

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
    echo $twig->render('order.twig', ['error' => 'Во время заказа произошла ошибка, попробуйте позже!']);
    die;
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

// Домашнее задание №5.1.3 (Добавьте отправление письма после регистрации в приложение из ВП1.)
try {
    $transport = (new \Swift_SmtpTransport(Settings::MAIL_SERVER, Settings::MAIL_PORT))
        ->setUsername(Settings::MAIL_USER)
        ->setPassword(Settings::MAIL_PASS)
        ->setEncryption(Settings::MAIL_ENCRYPTION);

    $mailer = new \Swift_Mailer($transport);

    $message = (new \Swift_Message("Заказ №{$orderId}"))
        ->setFrom([Settings::MAIL_USER => Settings::MAIL_FROM_NAME])
        ->setTo([$curUser->mail])
        ->setBody($mailText);

    $result = $mailer->send($message);
} catch (\Exception $e) {
/* resend msg or write to log */
}


echo $twig->render('order.twig');
