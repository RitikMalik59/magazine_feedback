<?php
include "../config/db_connect.php";
if (isset($_POST['feedback_submit'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $company = $_POST['company'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $answer_1 = implode('; ', $_POST['answer_1']);
    $answer_2 = implode('; ', $_POST['answer_2']);
    $answer_3 = ($_POST['answer_3'] == 'no') ? 'No' : 'Yes : ' . $_POST['answer_3'];
    $answer_4 = $_POST['answer_4'];
    $answer_5 = $_POST['answer_5'];
    $answer_6 = $_POST['answer_6'];

    // prepare sql and bind parameters
    try {
        $query = "INSERT INTO feedback (name, designation, company, phone, email, answer_1, answer_2, answer_3, answer_4, answer_5, answer_6)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        // var_dump($stmt);
        $stmt->execute([$name, $designation, $company, $phone, $email, $answer_1, $answer_2, $answer_3, $answer_4, $answer_5, $answer_6]);
        $last_inserted_id = $connection->lastInsertId();
        // echo $last_inserted_id;
        // echo "<br> Inserted successfully .";
        redirect('../thank_you.php?id=' . $last_inserted_id);
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage() . '<BR>';
    }
}
