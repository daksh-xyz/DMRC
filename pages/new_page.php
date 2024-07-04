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
    $username = $_SESSION['username'];
    ?>
    <header>
        <div class="head">
            <img src="../assets/images/logo.png" width="100px" height="39px">
            <div>
                <a class="link" href="profile.php"><?php echo "$username" ?></a>
                <a class="link" href="../php/logout.php">Logout</a>
            </div>
        </div>
    </header>
</body>

</html>