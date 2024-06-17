<?php
// var_dump($_POST);
// var_dump($_FILES);
?>

<?php

// Load the database configuration file 
include_once "../../config/db_connect.php";

$res_status = $res_msg = '';
if (isset($_POST['importSubmit'])) {
    // Allowed mime types 
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel');
    $text_csv_format = ['text/csv'];

    // Validate whether selected file is a CSV file 
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $text_csv_format)) {

        // If the file is uploaded 
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode 
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line 
            // fgetcsv($csvFile);

            // echo '<br>';
            // echo count(fgetcsv($csvFile));

            // Skip the first line 
            if (count(fgetcsv($csvFile)) > 1) {

                echo 'csv file separated by comma';

                // Parse data from CSV file line by line 
                while (($line = fgetcsv($csvFile)) !== FALSE) {
                    // if (count($line) == 1) {
                    // for semi colon separated csv file
                    //     $line = fgetcsv($csvFile, null, ';');
                    //     // var_dump($line);
                    // }
                    $line_arr = !empty($line) ? array_filter($line) : '';

                    if (!empty($line_arr)) {
                        // Get row data 
                        $name   = trim($line_arr[0]);
                        $designation = trim($line_arr[1]);
                        $company = trim($line_arr[2]);
                        $phone = trim($line_arr[3]);
                        $email = trim($line_arr[4]);

                        // // Check whether member already exists in the database with the same email 
                        // $prevQuery = "SELECT id FROM members WHERE email = '" . $email . "'";
                        // $prevResult = $db->query($prevQuery);

                        // if ($prevResult->num_rows > 0) {
                        //     // Update member data in the database 
                        //     $db->query("UPDATE members SET name = '" . $name . "', phone = '" . $phone . "', status = '" . $status . "', modified = NOW() WHERE email = '" . $email . "'");
                        // } else {
                        //     // Insert member data in the database 
                        //     $db->query("INSERT INTO members (name, email, phone, created, modified, status) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', NOW(), NOW(), '" . $status . "')");
                        // }

                        // prepare sql and bind parameters
                        try {
                            $query = "INSERT INTO old_records (name, designation, company, phone, email) VALUES (?, ?, ?, ?, ?)";
                            $stmt = $connection->prepare($query);
                            $stmt->execute([$name, $designation, $company, $phone, $email]);
                            // $last_inserted_id = $connection->lastInsertId();
                        } catch (\PDOException $e) {
                            echo "Error: " . $e->getMessage() . '<BR>';
                        }
                    }
                }

                // Close opened CSV file 
                fclose($csvFile);

                $res_status = 'success';
                $res_msg = 'Members data has been imported successfully.';
            } else {

                echo 'csv format not separated by comma';
                $res_status = 'danger';
                $res_msg = 'Please select a valid CSV file, which is separated by comma only';
                echo '<br> not correct type csv <br>';
            }
        } else {
            $res_status = 'danger';
            $res_msg = 'Something went wrong, please try again.';
        }
    } else {
        $res_status = 'danger';
        $res_msg = 'Please select a valid CSV file.';
        echo '<br> not correct type csv <br>';
    }

    // Store status in SESSION 
    $_SESSION['response'] = array(
        'status' => $res_status,
        'msg' => $res_msg
    );
}

// Redirect to the listing page 
redirect('../upload_data.php');
exit();

?>