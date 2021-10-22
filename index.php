<?php

header('Access-Control-Allow-Origin: https://itkilleddave.github.io');  
header('Access-Control-Allow-Methods: GET, OPTIONS');

define("CSV", "users.csv");

$search = $_GET['search'] ?? null;

$results = [];

if ($search) {
    try {

        if ( !file_exists(CSV) ) {
            throw new Exception('CSV data not found.');
        }
        
        $handle = fopen(CSV, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            if (strpos(strtolower($data[0]), strtolower($search)) !== false) {
                $results[] = [
                    "username"      => $data[0],
                    "firstname"     => $data[1],
                    "lastname"      => $data[2],
                    "email"         => $data[3],
                    "idnumber"      => $data[4],
                    "ja_id"         => $data[5],
                    "manager_id"    => $data[6],
                    "org_id"        => $data[7],
                ];
            }
        }
        fclose($handle);
        
    } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage(), "\n";
    }
}

$resultsJson = json_encode($results, JSON_PRETTY_PRINT);

echo $resultsJson;

?>