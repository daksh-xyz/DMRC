<?php
include ("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumniId = $_POST['alumni_id'];
    $docid = uniqid("ald");

    $verify_query = $con->prepare("SELECT * FROM alumni_docs WHERE SenderID = ? AND (F16Status='NA' OR pSlipStatus='NA' OR SAnnuationStatus='NA' OR ServiceCertificateStatus='NA' OR ReleaseLetterStatus='NA')");
    $verify_query->bind_param('i', $alumniId);
    $verify_query->execute();
    $verify_query->store_result();

    if ($verify_query->num_rows != 0) {
        $statusFields = ['F16Status', 'pSlipStatus', 'SAnnuationStatus', 'ServiceCertificateStatus', 'ReleaseLetterStatus'];
        foreach ($statusFields as $field) {
            $query = "UPDATE alumni_docs SET $field='Requested' WHERE SenderID='$alumniId'";
            $result = mysqli_query($con, $query);
        }
        if ($result) {
            echo "Sent document request!";
        } else {
            echo mysqli_error($con);
        }
    } else {

        $verify_query = $con->prepare("SELECT * FROM alumni_docs WHERE SenderID = ? AND (F16Status='Requested' OR pSlipStatus='Requested' OR SAnnuationStatus='Requested' OR ServiceCertificateStatus='Requested' OR ReleaseLetterStatus='Requested')");
        $verify_query->bind_param('i', $alumniId);
        $verify_query->execute();
        $verify_query->store_result();

        if ($verify_query->num_rows == 0) {
            $query = $con->prepare("INSERT INTO alumni_docs (DocID, SenderID) VALUES (?, ?)");
            $query->bind_param('ss', $docid, $alumniId);

            if ($query->execute()) {
                echo 'Sent document request!';
            } else {
                echo 'Error: ' . $query->error;
            }
            $query->close();
        } else {
            echo 'Document request already exists for this alumni.';
        }
        $verify_query->close();
    }
}

$con->close();
?>