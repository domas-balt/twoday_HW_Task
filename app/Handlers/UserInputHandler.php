<?php

namespace Handlers;

use Services\CharityService;
use Services\DonationService;

class UserInputHandler{
    private $charityService;
    private $donationService;
    private $validationHandler;

    public function __construct(CharityService $charityService, DonationService $donationService, ValidationHandler $validationHandler){
        $this->charityService = $charityService;
        $this->donationService = $donationService;
        $this->validationHandler = $validationHandler;
    }

    public function addCharity(){
        echo "Enter Charity Name:\n";
        $name = trim(fgets(STDIN));

        echo "Enter Representative Email:\n";
        $email = trim(fgets(STDIN));
        if(!$this->validationHandler->validateEmail($email)) return;

        $this->charityService->addCharity($name, $email);
        echo "Charity created!\n";
    }

    public function viewDonations(){
        echo "Enter Charity ID:\n";
        $id = trim(fgets(STDIN));
        if(!$this->validationHandler->validateCharityId($id)) return;

        $donations = $this->donationService->getDonationsByCharityId($id);

        foreach($donations as $donation){
            echo "ID: " . $donation->getId() . ", Donor Name: " . $donation->getDonorName() . ", Amount: " . $donation->getAmount() . " Charity ID: " . $donation->getCharityId() . ", Date Time: " . $donation->getDateTime() . "\n";
        }
    }

    public function viewCharities(){
        $charities = $this->charityService->getAllCharities();
        if(empty($charities)){
            echo "No Charities have been found.\n";
            return;
        }
        foreach($charities as $charity){
            echo "ID: " . $charity->getId() . ", Name: " . $charity->getName() . " Email: " . $charity->getRepresentativeEmail() . "\n";
        }
    }

    public function editCharity(){
        echo "Enter the ID of the Charity you want to edit:\n";
        $id = trim(fgets(STDIN));
        if (!$this->validationHandler->validateCharityId($id)) return;

        echo "Enter new Charity Name:\n";
        $newName = trim(fgets(STDIN));

        echo "Enter new Charity Email:\n";
        $newEmail = trim(fgets(STDIN));
        if (!$this->validationHandler->validateEmail($newEmail)) return;

        $charity = $this->charityService->editCharity($id, $newName, $newEmail);
        if ($charity){
            echo "Charity updated successfully.\n";
        } else {
            echo "Failed to update Charity.\n";
        }
    }

    public function deleteCharity(){
        echo "Enter the ID of the Charity you want to delete:\n";
        $id = trim(fgets(STDIN));
        if (!$this->validationHandler->validateId($id)) return;

        if ($this->charityService->deleteCharity($id)){
            echo "Charity deleted successfully.\n";
        } else {
            echo "Failed to delete Charity.\n";
        }
    }

    public function addDonation(){
        echo "Enter Donor Name:\n";
        $donorName = trim(fgets(STDIN));

        echo "Enter Amount:\n";
        $amount = trim(fgets(STDIN));
        if (!$this->validationHandler->validateAmount($amount)) return;

        echo "Enter Charity ID:\n";
        $charityId = trim(fgets(STDIN));
        if (!$this->validationHandler->validateCharityId($charityId)) return;

        $dateTime = date("Y-m-d H:i:s");

        $this->donationService->addDonation($donorName, $amount, $charityId, $dateTime);
        echo "Donation created successfully.\n";
    }
}