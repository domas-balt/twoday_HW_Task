<?php

namespace Handlers;

use Services\CharityService;
class ValidationHandler{
    private $charityService;

    public function __construct(CharityService $charityService){
        $this->charityService = $charityService;
    }

    public function validateEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "Invalid email formatting.\n";
            return false;
        }
        return true;
    }

    public function validateAmount($amount){
        if(!is_numeric($amount) || $amount < 0){
            echo "Donation amount must be a positive number.\n";
            return false;
        }
        return true;
    }

    public function validateCharityId($charityId){
        if(!$this->charityService->getCharityById($charityId)){
            echo "Charity with the ID: $charityId has not been found.\n";
            return false;
        }
        return true;
    }

    public function validateId($id){
        if(!is_numeric($id) || $id < 0){
            echo "ID must be a positive number.\n";
            return false;
        }
        return true;
    }

    public function validateCharityData($name, $email){
        $isValid = true;

        if (empty($name) || empty($email)){
            echo "Name and email cannot be empty.\n";
            $isValid = false;
        }

        if (!$this->validateEmail($email)){
            $isValid = false;
        }

        return $isValid;
    }
}