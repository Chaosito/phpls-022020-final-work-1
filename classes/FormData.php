<?php

class FormData
{
    public $name;
    public $phone;
    public $mail;
    public $street;
    public $house;
    public $building;
    public $apartment;
    public $floor;
    public $comment;
    public $payment;
    public $notCall;

    public function __construct()
    {
        $this->name = $this->tryString($_POST['name']);
        $this->phone = $this->tryString($_POST['phone']);
        $this->mail = $this->tryString($_POST['email']);
        $this->street = $this->tryString($_POST['street']);
        $this->house = $this->tryString($_POST['home']);
        $this->building = $this->tryString($_POST['part']);
        $this->apartment = $this->tryString($_POST['appt']);
        $this->floor = $this->tryString($_POST['floor']);
        $this->comment = $this->tryString($_POST['comment']);
        $this->payment = $this->tryString($_POST['payment']);
        $this->notCall = $this->tryInt($_POST['callback']);
    }

    private function tryString($inputData)
    {
        return (!empty($inputData) ? strip_tags(trim($inputData)) : '');
    }

    private function tryInt($inputData)
    {
        return (!empty($inputData) ? (int)$inputData : 0);
    }
}
