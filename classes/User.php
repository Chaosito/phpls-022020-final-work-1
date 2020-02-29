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

    const AVAILABLE_FIELDS_FOR_SEARCH = array('id', 'mail');

    /**
     * Поиск пользователя в БД по имени и значению поля
     * @param string $fieldName Поле таблицы БД
     * @param string $fieldValue Значение поля
     * @return bool Найден ли пользователь
     */
    public function findUserBy(string $fieldName, string $fieldValue)
    {
        // Можно расширить данный метод, чтобы он принимал многомерный массив параметров
        // или возвращал большее количество пользователей (поля на выбор), но нам это ни к чему.
        if (!in_array($fieldName, self::AVAILABLE_FIELDS_FOR_SEARCH)) {
            return false;
        }

        $res = DB::run("SELECT * FROM users WHERE {$fieldName} = ? LIMIT 1;", [$fieldValue])->fetch();
        if ($res) {
            $this->fetchUser($res);
        }
        return (bool)$res;
    }

    public function register(FormData $formData)
    {
        $userData = [
            $formData->name,
            $formData->phone,
            $formData->mail,
            $formData->street,
            $formData->house,
            $formData->building,
            $formData->apartment,
            $formData->floor
        ];

        DB::run("
            INSERT INTO 
                users (dt_reg, first_name, phone, mail, street, house, building, apartment, floor) 
            VALUES 
                (now(), ?, ?, ?, ?, ?, ?, ?, ?)
        ", $userData);
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
