<?php

require_once 'Models/Charity.php';
require_once 'Models/Donation.php';
require_once 'Services/CharityService.php';
require_once 'Services/DonationService.php';
require_once 'Handlers/ValidationHandler.php';
require_once 'Handlers/UserInputHandler.php';

use Services\CharityService;
use Services\DonationService;
use Handlers\ValidationHandler;
use Handlers\UserInputHandler;

class Main{
    private $userInputHandler;

    public function __construct(){
        $charityService = new CharityService();
        $donationService = new DonationService();

        $validationHandler = new ValidationHandler($charityService);

        $this->userInputHandler = new UserInputHandler($charityService, $donationService, $validationHandler);
    }
    public function run(){
        echo "Domas Baltrušaitis 'twoday' PHP Internship Homework Task\n";

        while (true)
        {
            echo "Enter a command (type 'exit' to quit)\n";
            $command = trim(fgets(STDIN));

            if ($command == 'exit') {
                echo "Exiting application.";
                break;
            }

            $this->processCommand($command);
        }
    }

    private function processCommand($command){
        switch ($command) {
            case 'add_charity':
                $this->userInputHandler->addCharity();
                break;
            case 'view_charities':
                $this->userInputHandler->viewCharities();
                break;
            case 'edit_charity':
                $this->userInputHandler->editCharity();
                break;
            case 'delete_charity':
                $this->userInputHandler->deleteCharity();
                break;
            case 'add_donation':
                $this->userInputHandler->addDonation();
                break;
            case 'view_donations':
                $this->userInputHandler->viewDonations();
                break;
            default:
                echo "Unknown command '$command'";
        }
    }
}

$application = new Main();
$application->run();