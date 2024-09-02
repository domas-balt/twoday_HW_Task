<?php

namespace Services;

use Models\Donation;

class DonationService{
    private $donationArray = [];
    private $autoIncrement = 1;
    public function addDonation($donorName, $amount, $charityId, $dateTime){
        $donation = new Donation($this->autoIncrement, $donorName, $amount, $charityId, $dateTime);
        $this->donationArray[] = $donation;
        $this->autoIncrement++;
        return $donation;
    }

    public function getDonationsByCharityId($charityId){
        $charityDonations = [];
        foreach($this->donationArray as $donation){
            if($donation->getCharityId() === $charityId){
                $charityDonations[] = $donation;
            }
        }
        return $charityDonations;
    }
}