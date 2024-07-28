<?php
include ("../php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumniId = $_POST['alumni_id'];
    $docid = $_POST['doc_id'];

    $query = "UPDATE alumni_docs SET $docid='null' WHERE SenderID='$alumniId'";
    if (mysqli_query($con, $query)) {
        echo "Document deleted successfully";
    } else {
        echo "Failed to delete document";
    }
}
?>