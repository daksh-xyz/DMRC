<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumniId = $_POST['alumni_id'];


    $query = "UPDATE alumni_docs SET F16Status='NA', pSlipStatus='NA', SAnnuationStatus='NA', ServiceCertificateStatus='NA', ReleaseLetterStatus='NA' WHERE SenderID='$alumniId'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo 'Success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}
?>