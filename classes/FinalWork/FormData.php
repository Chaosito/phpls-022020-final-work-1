<?php
namespace FinalWork;

use Service\Globals\AdapterPost;
use Service\Globals\GlobalsFactory as GF;

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
        GF::init(new AdapterPost());
        $this->name = $this->tryString(GF::get('name', ''));
        $this->phone = $this->tryString(GF::get('phone', ''));
        $this->mail = $this->tryString(GF::get('email', ''));
        $this->street = $this->tryString(GF::get('street', ''));
        $this->house = $this->tryString(GF::get('home', ''));
        $this->building = $this->tryString(GF::get('part', ''));
        $this->apartment = $this->tryString(GF::get('appt', ''));
        $this->floor = $this->tryString(GF::get('floor', ''));
        $this->comment = $this->tryString(GF::get('comment', ''));
        $this->payment = $this->tryString(GF::get('payment', ''));
        $this->notCall = $this->tryInt(GF::get('callback', ''));
    }

    private function tryString($inputData)
    {
        return strip_tags(trim($inputData));
    }

    private function tryInt($inputData)
    {
        return (int)$inputData;
    }
}
