<?php

namespace Models;

class Charity{
    private $id;
    private $name;
    private $representativeEmail;

    public function __construct($id, $name, $representativeEmail){
        $this->id = $id;
        $this->name = $name;
        $this->representativeEmail = $representativeEmail;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getRepresentativeEmail(){
        return $this->representativeEmail;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setRepresentativeEmail($representativeEmail){
        $this->representativeEmail = $representativeEmail;
    }
}