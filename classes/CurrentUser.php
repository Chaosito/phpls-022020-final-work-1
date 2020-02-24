<?php

/*
  Класс CurrentUser
  Текущий пользователь (вошедший в систему), расширяет базовый класс User
*/

class CurrentUser extends User
{
    private $_logged = false;

    public function __construct()
    {
        $uid = 0;

        // check session & cookie
        if (empty($_SESSION['user_id']) && empty($_COOKIE["user_mail"])) return;

        // get data from session and cookie; and authorize or not;
        if (isset($_SESSION['user_id'])) {
            $uid = $this->findById($_SESSION['user_id']);
        } else {
            $uid = $this->findByMail($_COOKIE["user_mail"]);
        }

        if (!$uid) return;

        $_SESSION['user_id'] = $uid;
        $this->_logged = true;
    }

    public function updateInformation($userId, $name, $phone, $street, $home, $part, $appt, $floor)
    {
        $userData = [$name, $phone, $street, $home, $part, $appt, $floor, $userId];
        DB::run("UPDATE users SET first_name = ?, phone = ?, street = ?, house = ?, building = ?, apartment = ?, floor = ? WHERE id = ? LIMIT 1;", $userData);
    }

    public function isLogged()
    {
        return $this->_logged;
    }

    public function login($uid, $mail)
    {
        $_SESSION['user_id'] = $uid;
        setcookie('user_mail', $mail, time() + Settings::COOKIE_LIFE_TIME, "/");
        self::__construct(); // Переинициализируем себя
    }

    public function logout()
    {
        $this->_logged = false;
        if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
        setcookie('user_mail', '', 0, "/");
    }

}
