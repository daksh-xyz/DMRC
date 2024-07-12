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
    $query = "SELECT * from alumni_details where Alumni_id = $id";
    $qresult = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($qresult);
    $BID = $row['BatchID'];
    $dept = $row['Department'];
    $jDate = $row['Join_Date'];
    $lDate = $row['Last_date'];
    $UAN = $row['UAN'];
    $PF = $row['PF'];
    $PAN = $row['PAN'];
    $PNum = $row['Pension_Number'];
    if ($BID == "" || $dept == "" || $jDate == "" || $lDate == "" || $UAN == "" || $PF == "" || $PAN == "" || $PNum == "") {
        echo "<script>alert('Please complete profile first!');window.location.href = 'profile.php';</script>";
    } else {
        $verify_query = mysqli_query($con, "SELECT * FROM connections WHERE Alumni_id = $id");
        if (!mysqli_num_rows($verify_query)) {
            $initiate_social = mysqli_query($con, "INSERT INTO connections(Alumni_id,User_id,FriendshipStatus) VALUES ($id,$id, 0);");
        }
        ?>
        <header>
            <div class="head">
                <a href="home.php"><img src="../assets/images/logo.png" width="100px" height="39px"></a>
                <div>
                    <div class="off-screen-menu">
                        <div class="top">
                            <ul>
                                <li><a href="home.php">Home</a></li>
                                <li><a href="socialize.php">Socialize</a></li>
                                <li><a href="profile.php">Profile</a></li>
                            </ul>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li><a href="../php/logout.php" id="menu-logout"><img src="">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <nav>
                        <div class="ham-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </nav>
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
        <script>
            const hamMenu = document.querySelector('.ham-menu');
            const offScreenMenu = document.querySelector('.off-screen-menu');
            hamMenu.addEventListener('click', () => {
                hamMenu.classList.toggle('active');
                offScreenMenu.classList.toggle('active');
            })
        </script>
    <?php } ?>
</body>

</html>