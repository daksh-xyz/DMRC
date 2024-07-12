<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $alumniId = $_POST['alumni_id'];

    $query = "DELETE FROM connections WHERE Alumni_id=$alumniId AND User_id=$userId";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo 'Success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}
?>