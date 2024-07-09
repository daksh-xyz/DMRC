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
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
    }
    $id = $_SESSION['id'];
    $query = "SELECT BatchID from alumni_details where Alumni_id = $id";
    $qresult = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($qresult);
    $BID = $row['BatchID'];
    if ($BID == "") {
        echo "<script>window.location.href = 'profile.php';</script>";
    }

    ?>
    <header>
        <div class="head">
            <a href="home.php"><img src="../assets/images/logo.png" width="100px" height="39px"></a>
            <div>
                <a href="socialize.php" class="link">Socialize</a>
                <a class="link" href="profile.php">My Profile</a>
                <a id="logout" class="link" href="../php/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <div class="center">
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
                <p>Superannuation Statement</p>
            </div>
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
                <p>Service Certificate</p>
            </div>
            <div class="col">
                <a href="../assets/images/pdf.png" download><img src="../assets/images/pdf.png" height="50px"></a>
                <p>Release Letter</p>
            </div>
        </div>
    </div>
</body>

</html>