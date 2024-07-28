<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $alumniId = $_POST['alumni_id'];

    $verify_query = mysqli_query($con, "SELECT * FROM connections WHERE Alumni_id=$alumniId AND User_id=$userId");
    if (mysqli_num_rows($verify_query)) {
        echo 'Request already sent!';
    } else {
        $query = "INSERT INTO connections(Alumni_id, User_id, FriendshipStatus) VALUES ($alumniId, $userId, 0)";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo 'Friend request sent!';
        } else {
            echo 'Error: ' . mysqli_error($con);
        }

    }

}
?>