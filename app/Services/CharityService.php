<?php

namespace Services;

use Models\Charity;

class CharityService {
    private $charityArray = [];
    private $autoIncrement = 1;

    public function addCharity($name, $email) {
        $charity = new Charity($this->autoIncrement, $name, $email);
        $this->charityArray[] = $charity;
        $this->autoIncrement++;
        return $charity;
    }

    public function getAllCharities(){
        return $this->charityArray;
    }

    public function getCharityById($id) {
        foreach ($this->charityArray as $charity) {
            if ($charity->getId() == $id) {
                return $charity;
            }
        }
        return null;
    }

    public function editCharity($id, $newName, $newEmail) {
        $charity = $this->getCharityById($id);
        if ($charity){
            $charity->setName($newName);
            $charity->setRepresentativeEmail($newEmail);
            return $charity;
        }
        return null;
    }

    public function deleteCharity($id) {
        $initialCharityCount = count($this->charityArray);

        $this->charityArray = array_values(array_filter($this->charityArray, function($charity) use($id) {
            return (int)$charity->getId() !== (int)$id;
        }));

        return count($this->charityArray) < $initialCharityCount;
    }
}