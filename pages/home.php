<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/styles.css">
    <link rel="stylesheet" href="../src/HomeStyle.css">
    <title>Home Page</title>
</head>

<body>
    <?php
    include ("../php/config.php");
    if (!isset($_SESSION['username'])) {
        header("Location: ../index.php");
    }
    $id = $_SESSION['id'];
    $query = "SELECT BatchID from alumni_details where Alumni_id = $id";
    $qresult = mysqli_query($con, $query);
    echo "$id";

    ?>
    <header>
        <div class="head">
            <img src="../assets/images/logo.png" width="100px" height="39px">
            <div>
                <a class="link" href="profile.php">My Profile</a>
                <a id="logout" class="link" href="../php/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
                <p>Form 16</p>
            </div>
            <div class="col">
                <a href="../assets/images/policy.png" download><img src="../assets/images/policy.png" height="50px"></a>
                <p>Pay Slip</p>
            </div>
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
            </div>
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
            </div>
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
            </div>
        </div>
    </div>
</body>

</html>