<?php

namespace FinalWork;

class Order
{
    private $id = 0;
    private $userId = 0;
    public $address = '';
    private $comment = '';
    private $needChange = 0;
    private $cardPayment = 0;
    private $notCall = 0;

    public function __construct(User $forUser)
    {
        $this->userId = $forUser->id;
        $this->createAddressField($forUser);
    }

    public function createOrder(FormData $formData)
    {
        $this->comment = $formData->comment;
        $this->parsePaymentOptions($formData->payment);
        $this->notCall = $formData->notCall;

        $arrOrder = [
            $this->userId,
            $this->address,
            $this->comment,
            $this->needChange,
            $this->cardPayment,
            $this->notCall
        ];

        DB::run("
            INSERT INTO 
                orders (user_id, order_date, address, `comment`, need_change, card_payment, not_call) 
            VALUES 
                (?, NOW(), ?, ?, ?, ?, ?)
        ", $arrOrder);
        return DB::lastInsertId();
    }

    private function parsePaymentOptions($paymentVariable = '')
    {
        $this->needChange = ($paymentVariable == 'need_change') ? 1 : 0;
        $this->cardPayment = ($paymentVariable == 'card') ? 1 : 0;
    }

    private function createAddressField(User $user)
    {
        $this->address = "Улица: {$user->street}, Дом: {$user->house}".
            (!empty($user->building) ? ", Корпус: {$user->building}" : "").
            (!empty($user->apartment) ? ", Квартира: {$user->apartment}" : "").
            (!empty($user->floor) ? ", Этаж: {$user->floor}" : "");
    }
}
