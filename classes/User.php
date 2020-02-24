<?php

/*
  Класс User
  Все что касается пользаков
*/

class User
{
    public $id;
    public $first_name;
    public $phone;
    public $mail;
    public $street;
    public $house;
    public $building;
    public $apartment;
    public $floor;

    public function __construct()
    {
        
    }

    private function findUser($userId = 0, $mail = '')
    {
        $q = "SELECT * FROM users WHERE ";
        $res = false;

        if ((int)$userId > 0) {
            $q .= "id = ? LIMIT 1;";
            $res = DB::run($q, array($userId))->fetch();
        } elseif (trim($mail) != '') {
            $q .= "mail = ? LIMIT 1;";
            $res = DB::run($q, array($mail))->fetch();
        }

        if ($res) {
            $this->fetchUser($res);
            return $res->id;
        } else {
            return false;
        }
    }

    public function findById($uid)
    {
        if ((int)$uid <= 0) throw new Exception('Идентификатор пользователя не указан!');
        $uid = $this->findUser($uid);
        return $uid;
    }

    public function findByMail($mail)
    {
        if ((trim($mail) == "") || (!filter_var($mail, FILTER_VALIDATE_EMAIL))) throw new Exception('E-Mail не верен!');
        $uid = $this->findUser(0, $mail);
        return $uid;
    }

    public function register($name, $phone, $mail, $street, $house, $building, $apartment, $floor){
        $userData = [$name, $phone, $mail, $street, $house, $building, $apartment, $floor];
        DB::run("INSERT INTO users (dt_reg, first_name, phone, mail, street, house, building, apartment, floor) VALUES (now(), ?, ?, ?, ?, ?, ?, ?, ?)", $userData);
        return DB::lastInsertId();
    }

    protected function fetchUser($userData)
    {
        /* table `users` */
        $this->id = $userData['id'];
        $this->first_name = $userData['first_name'];
        $this->phone = $userData['phone'];
        $this->mail = $userData['mail'];
        $this->street = $userData['street'];
        $this->house = $userData['house'];
        $this->building = $userData['building'];
        $this->apartment = $userData['apartment'];
        $this->floor = $userData['floor'];
    }
}
