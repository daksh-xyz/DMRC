<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/SocialStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>DMRC | Socialize</title>
</head>

<body>
    <?php
    include ("../php/config.php");
    if (!isset($_SESSION["id"])) {
        header("Location: ../index.php");
        exit();
    } else {
        $id = $_SESSION['id'];
        $fname = $lname = $ldate = $dept = "";
        if (isset($_POST['search'])) {
            $fullname = $_POST['Name'];
            if ($fullname != '') {
                $fullname = explode(" ", $fullname, 2);
                $fname = $fullname[0];
                $lname = $fullname[1];
            }
            $ldate = $_POST['lDate'];
            if ($ldate != '') {
                $ldate = explode("-", $ldate, 3);
                $lyear = $ldate[0];
                $lmonth = $ldate[1];
            }
            $dept = $_POST['department'];
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
                                <li><a href="profile.php">My Profile</a></li>
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
                    <a href="home.php" class="link">Home</a>
                    <a href="socialize.php" class="link">Socialize</a>
                    <a class="link" href="profile.php">My Profile</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>
        <div class="space"></div>
        <div class="SearchContainer">
            <div class="box">
                <form action="search.php" method="post">
                    <h2>Search by Alumni Information</h2>
                    <input type="text" name="Name" placeholder="Name of Alumni">
                    <input placeholder="Date of Retirement" name="lDate" class="textbox-n" type="text"
                        onfocus="(this.type='date')" onblur="(this.type='text')" id="date" />
                    <select name="department">
                        <option value="">Select Department</option>
                        <option value="IT">IT</option>
                        <option value="Mechanical">Mechanical</option>
                        <option value="Civil">Civil</option>
                        <option value="HR">HR</option>
                        <option value="Finance">Finance</option>
                        <option value="Engineering">Engineering</option>
                    </select>
                    <input id="search" type="submit" name="search" value="Search"></input>
                </form>
            </div>
        </div>
        <div class="ResultContainer">
            <div class="alumni-grid">
                <?php
                $query = "SELECT a.*, ad.*, c.*
                FROM alumni a
                JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id
                JOIN connections c ON a.Alumni_id = c.Alumni_id
                WHERE 
                    (a.First_Name = ? AND a.Last_Name = ? AND a.Alumni_id != ?)
                    OR (MONTH(ad.Last_date) = ? AND YEAR(ad.Last_date) = ? AND a.Alumni_id != ?)
                    OR (ad.Department = ? AND a.Alumni_id != ?)
                GROUP BY a.Alumni_id;
                ";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ssissisi", $fname, $lname, $id, $lmonth, $lyear, $id, $dept, $id);
                $stmt->execute();
                $getFriends_query = $stmt->get_result();
                if (!$getFriends_query) {
                    echo "Error: " . $con->error;
                    exit();
                }
                if (!mysqli_num_rows($getFriends_query)) {
                    echo "
                            <div class='empty'>
                                <p>No friends yet? Find and connect with other alumni to build your network!</p>
                                <img src='../assets/images/add-user.png' width='55px'>
                            </div>
                        ";
                } else {
                    while ($getFriends = $getFriends_query->fetch_assoc()) {
                        $name = htmlspecialchars($getFriends['First_Name'] . " " . htmlspecialchars($getFriends['Last_Name']));
                        $pfp = htmlspecialchars($getFriends['pfp']);
                        $AID = $id;
                        $UID = htmlspecialchars($getFriends['User_id']);
                        $fstatus = htmlspecialchars($getFriends['FriendshipStatus']);
                        $stmt2 = $con->prepare("SELECT * FROM alumni_details WHERE Alumni_id = ?");
                        $stmt2->bind_param("i", $UID);
                        $stmt2->execute();
                        $getBatchID_query = $stmt2->get_result();
                        if (!$getBatchID_query) {
                            echo "Error: " . $con->error;
                            exit();
                        }
                        $getBatchID = $getBatchID_query->fetch_assoc();
                        $BID = htmlspecialchars($getBatchID['BatchID']);
                        echo '
                        <div class="alumni-box">
                            <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                            <div class="alumni-info">
                                <p class="alumni-name">' . $name . '</p>
                                <p class="alumni-detail">Batch ID:' . $BID . '</p>
                                <button class="connect-button" onclick="run(' . $UID . ', ' . $AID . ', ' . $fstatus . ')">' . ($fstatus ? "unfriend" : "connect") . '</button>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
        <script>
            function run(userId, alumniId, fstatus) {
                $.ajax({
                    type: 'POST',
                    url: '../php/searchAlumni.php',
                    data: {
                        user_id: userId,
                        alumni_id: alumniId,
                        f_status: fstatus
                    },
                    success: function (response) {
                        alert('Success!');
                        window.location.href = "socialize.php"
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
            const hamMenu = document.querySelector('.ham-menu');
            const offScreenMenu = document.querySelector('.off-screen-menu');
            hamMenu.addEventListener('click', () => {
                hamMenu.classList.toggle('active');
                offScreenMenu.classList.toggle('active');
            });

            date.max = new Date().toISOString().slice(0, -14);
        </script>
    <?php } ?>
</body>

</html>