<?php

/*
  Класс CurrentUser
  Текущий пользователь (вошедший в систему), расширяет базовый класс User
*/

namespace FinalWork;

class CurrentUser extends User
{
    private $logged = false;

    public function __construct()
    {
        // check session & cookie
        if (empty($_SESSION['user_id']) && empty($_COOKIE["user_mail"])) {
            return;
        }

        if (isset($_SESSION['user_id'])) {
            $this->findUserBy('id', $_SESSION['user_id']);
        } else {
            $this->findUserBy('mail', $_COOKIE["user_mail"]);
        }

        if ($this->id) {
            $this->logged = true;
        }
    }

    public function updateInformation(FormData $formData)
    {
        $this->firstName = $formData->name;
        $this->phone = $formData->phone;
        $this->street = $formData->street;
        $this->house = $formData->house;
        $this->building = $formData->building;
        $this->apartment = $formData->apartment;
        $this->floor = $formData->floor;

        $userData = [
            $this->firstName,
            $this->phone,
            $this->street,
            $this->house,
            $this->building,
            $this->apartment,
            $this->floor,
            $this->id
        ];

        DB::run("
            UPDATE 
                users 
            SET 
                first_name = ?, phone = ?, street = ?, house = ?, building = ?, apartment = ?, floor = ? 
            WHERE 
                id = ? 
            LIMIT 1;
        ", $userData);
    }

    public function isLogged()
    {
        return $this->logged;
    }

    public function login($uid, $mail)
    {
        $_SESSION['user_id'] = $uid;
        setcookie('user_mail', $mail, time() + Settings::COOKIE_LIFE_TIME, "/");
        self::__construct(); // Переинициализируем себя
    }

    public function logout()
    {
        $this->logged = false;
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }
        setcookie('user_mail', '', 0, "/");
    }

    public function getOrdersCount()
    {
        return DB::run("SELECT COUNT(id) FROM orders WHERE user_id = ?", [$this->id])->fetchColumn();
    }
}
