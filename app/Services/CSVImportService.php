<?php

namespace Services;

use Services\CharityService;
use Handlers\ValidationHandler;

class CSVImportService{
    private $charityService;
    private $validationHandler;

    public function __construct(CharityService $charityService, ValidationHandler $validationHandler){
        $this->charityService = $charityService;
        $this->validationHandler = $validationHandler;
    }

    public function importCharitiesFromCSV($fileName){
        $filePath = __DIR__ . '/../Imports/' . $fileName;

        if (!file_exists($filePath) || !is_readable($filePath)) {
            echo "The file cannot be found or read.\n";
            return;
        }

        $file = fopen($filePath, "r");
        $header = fgetcsv($file);

        if (substr($header[0], 0, 3) === "\xef\xbb\xbf") {
            $header[0] = substr($header[0], 3);
        }

        $rowCount = 0;
        $successfulImports = 0;
        $failedImports = 0;

        while ($row = fgetcsv($file)) {
            $rowCount++;

            $data = array_combine($header, $row);

            $name = $data['name'];
            $email = $data['representativeEmail'];

            if (!$this->validationHandler->validateCharityData($name, $email)) {
                echo "Row $rowCount: Charity was not imported due to validation error.\n";
                $failedImports++;
                continue;
            }

            $this->charityService->addCharity($name, $email);
            $successfulImports++;
        }

        fclose($file);

        echo "Import has been completed. $successfulImports charities imported successfully. $failedImports failed.\n";
    }
}