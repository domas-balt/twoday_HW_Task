<?php

namespace Handlers;

use Services\CharityService;
use Services\DonationService;
use Services\CSVImportService;

class UserInputHandler{
    private $charityService;
    private $donationService;
    private $validationHandler;
    private $csvImportService;

    public function __construct(CharityService $charityService, DonationService $donationService, ValidationHandler $validationHandler, CSVImportService $csvImportService){
        $this->charityService = $charityService;
        $this->donationService = $donationService;
        $this->validationHandler = $validationHandler;
        $this->csvImportService = $csvImportService;
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
            echo $donation;
        }
    }

    public function viewCharities(){
        $charities = $this->charityService->getAllCharities();
        if(empty($charities)){
            echo "No Charities have been found.\n";
            return;
        }
        foreach($charities as $charity){
            echo $charity;
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

    public function importCharitiesFromCSV(){
        echo "Enter the name of the CSV file from which you want to import the charities (include the extension, for example, charities.csv)\n";
        $fileName = trim(fgets(STDIN));
        $this->csvImportService->importCharitiesFromCSV($fileName);
    }

    public function displayHelp(){
        echo "Available commands:\n";
        echo " import_charities - Import charities from a CSV file. Charities must be stored in the 'Imports' folder and the data must be comma separated.\n";
        echo " add_charity      - Add a new charity\n";
        echo " view_charities   - View all charities\n";
        echo " edit_charity     - Edit a charity\n";
        echo " delete_charity   - Delete a charity\n";
        echo " add_donation     - Add a new donation\n";
        echo " view_donations   - View all donations\n";
        echo " help             - Open this help message\n";
        echo " exit             - Exit the application\n";
    }
}