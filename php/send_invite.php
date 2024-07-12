<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $alumniId = $_POST['alumni_id'];

    $query = "INSERT INTO connections(Alumni_id, User_id, FriendshipStatus) VALUES ($alumniId, $userId, 0)";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo 'Success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}
?>