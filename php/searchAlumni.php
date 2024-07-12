<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $alumniId = $_POST['alumni_id'];
    $fstatus = $_POST['f_status'];

    if (!$fstatus) {
        $verify_query = mysqli_query($con, "SELECT * FROM connections WHERE Alumni_id=$alumniId AND User_id=$userId");
        if (mysqli_num_rows($verify_query)) {
            echo '<script>alert("Friend Request already sent!")</script>';
        } else {
            $query = "INSERT INTO connections(Alumni_id, User_id, FriendshipStatus) VALUES ($alumniId, $userId, 0)";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo 'Success';
            } else {
                echo 'Error: ' . mysqli_error($con);
            }

        }
    } else {
        $query = "DELETE FROM connections WHERE Alumni_id=$alumniId AND User_id=$userId";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo 'Success';
        } else {
            echo 'Error: ' . mysqli_error($con);
        }
    }

}
?>