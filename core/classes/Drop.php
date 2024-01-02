<?php

class Drop extends User  //Post
{
    protected $message;

    public function __construct($pdo){
        $this->pdo = $pdo;
        $this->message  = new Message($this->pdo);
    }
}