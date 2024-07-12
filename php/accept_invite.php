<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $alumniId = $_POST['alumni_id'];

    $query = "UPDATE connections SET FriendshipStatus = 1 WHERE User_id = $userId AND Alumni_id = $alumniId";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo 'Success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}
?>