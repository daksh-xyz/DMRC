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
    session_start();
    include ("../php/config.php");
    if (!isset($_SESSION["id"])) {
        header("Location: ../index.php");
        exit();
    } else {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM alumni_details WHERE Alumni_id = $id";
        $qresult = mysqli_query($con, $query);
        if (!$qresult) {
            echo "Error: " . mysqli_error($con);
            exit();
        }
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
            echo "<script>window.location.href = 'profile.php';</script>";
            exit();
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
                    <a href="home.php" class="link">Home</a>
                    <a class="link" href="profile.php">My Profile</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>
        <div class="space"></div>
        <div class="SearchContainer">
            <div class="box">
                <h2>Search by Alumni Information</h2>
                <input type="text" placeholder="Name of Alumni">
                <input placeholder="Date of Joining" class="textbox-n" type="text" onfocus="(this.type='date')"
                    onblur="(this.type='text')" id="date" />
                <input placeholder="Date of Retirement" class="textbox-n" type="text" onfocus="(this.type='date')"
                    onblur="(this.type='text')" id="date" />
                <select>
                    <option value="">Select Department</option>
                    <option value="IT">IT</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Civil">Civil</option>
                    <option value="HR">HR</option>
                    <option value="Finance">Finance</option>
                    <option value="Engineering">Engineering</option>
                </select>
                <button>Search</button>
            </div>
        </div>
        <div class="ResultContainer">
            <div class="tabs">
                <button class="tab active" onclick="showTab('friends', event)">Connections</button>
                <button class="tab" onclick="showTab('invitation', event)">Incoming Requests</button>
                <button class="tab" onclick="showTab('alumni-info', event)">Outgoing Requests</button>
            </div>
            <div id="friends" class="alumni-grid tab-content" style="display: flex;">
                <h3 id="recommendText">Suggested Alumni:</h3>
                <div class="recommendations">
                    <?php
                    $getBatchID_query = mysqli_query($con, "SELECT * FROM alumni_details WHERE Alumni_id=$id");
                    if (!$getBatchID_query) {
                        echo "Error: " . mysqli_error($con);
                        exit();
                    }
                    $getBatchID = mysqli_fetch_assoc($getBatchID_query);
                    $BID = $getBatchID['BatchID'];
                    $getrecommendations_query = mysqli_query($con, "SELECT a.*, ad.*, c.*
                    FROM alumni a
                    JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id
                    JOIN connections c ON a.Alumni_id = c.Alumni_id
                    WHERE c.Alumni_id != $id AND c.FriendshipStatus = 0
                    AND a.Alumni_id NOT IN (
                        SELECT c2.Alumni_id
                        FROM connections c2
                        WHERE c2.User_id = $id AND c2.FriendshipStatus = 1
                    )
                    GROUP BY a.Alumni_id;");
                    if (!$getrecommendations_query) {
                        echo "Error: " . mysqli_error($con);
                        exit();
                    } else {
                        while ($getrecommendations = mysqli_fetch_assoc($getrecommendations_query)) {
                            $name = $getrecommendations['First_Name'] . " " . $getrecommendations['Last_Name'];
                            $pfp = $getrecommendations['pfp'];
                            $AID = $id;
                            $UID = $getrecommendations['User_id'];
                            echo '<div class="alumni-box">
                                <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                                <div class="alumni-info">
                                    <p class="alumni-name">' . $name . '</p>
                                    <button class="connect-button" onclick="sendInvite(' . $UID . ', ' . $AID . ')">Connect</button>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <div>
                    <?php
                    $getFriends_query = mysqli_query($con, "SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.Alumni_id WHERE c.User_id = $id AND c.FriendshipStatus=1;");
                    if (!$getFriends_query) {
                        echo "Error: " . mysqli_error($con);
                        exit();
                    }
                    if (!mysqli_num_rows($getFriends_query)) {
                        echo "
                            <div class='empty'>
                                <p>No friends yet? Find and connect with other alumni to build your network!</p>
                                <img src='../assets/images/add-user.png' width='55px' >
                            </div>
                        ";
                    } else {
                        while ($getFriends = mysqli_fetch_assoc($getFriends_query)) {
                            $name = $getFriends['First_Name'] . " " . $getFriends['Last_Name'];
                            $pfp = $getFriends['pfp'];
                            $AID = $getFriends['Alumni_id'];
                            $UID = $getFriends['User_id'];
                            $getBatchID_query = mysqli_query($con, "SELECT * FROM alumni_details WHERE Alumni_id=$UID");
                            if (!$getBatchID_query) {
                                echo "Error: " . mysqli_error($con);
                                exit();
                            }
                            $getBatchID = mysqli_fetch_assoc($getBatchID_query);
                            $BID = $getBatchID['BatchID'];
                            echo '<div class="alumni-box">
                                <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                                <div class="alumni-info">
                                    <p class="alumni-name">' . $name . '</p>
                                    <p class="alumni-detail">Batch ID:' . $BID . '</p>
                                    <button class="connect-button" onclick="unfollowAlumni(' . $UID . ', ' . $AID . ')">Unfriend</button>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="invitation" class="alumni-grid tab-content" style="display:none;">
                <?php
                $getinvitations_query = mysqli_query($con, "SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.Alumni_id WHERE c.Alumni_id != $id AND c.User_id= $id AND c.FriendshipStatus=0;");
                if (!$getinvitations_query) {
                    echo "Error: " . mysqli_error($con);
                    exit();
                }
                while ($getinvitation = mysqli_fetch_assoc($getinvitations_query)) {
                    $name = $getinvitation['First_Name'] . " " . $getinvitation['Last_Name'];
                    $pfp = $getinvitation['pfp'];
                    $UID = $getinvitation['User_id'];
                    $AID = $getinvitation['Alumni_id'];
                    $getBatchID_query = mysqli_query($con, "SELECT * FROM alumni_details WHERE Alumni_id=$AID");
                    if (!$getBatchID_query) {
                        echo "Error: " . mysqli_error($con);
                        exit();
                    }
                    $getBatchID = mysqli_fetch_assoc($getBatchID_query);
                    $BID = $getBatchID['BatchID'];
                    echo '
                    <div class="alumni-box">
                        <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                        <div class="alumni-info">
                            <p class="alumni-name">' . $name . '</p>
                            <p class="alumni-detail">' . $BID . '</p>                            
                            <button class="connect-button" onclick="acceptInvite(' . $UID . ', ' . $AID . ')">Accept</button>
                        </div>
                    </div>';
                }
                ?>
            </div>
            <div id="alumni-info" class="alumni-grid tab-content" style="display:none;">
                <?php
                $getRequest_query = mysqli_query($con, "SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.User_id WHERE c.Alumni_id= $id AND c.User_id != $id AND c.FriendshipStatus=0;");
                if (!$getRequest_query) {
                    echo "Error: " . mysqli_error($con);
                    exit();
                }
                if (!mysqli_num_rows($getRequest_query)) {
                    echo "
                    <div class='empty'>
                        <p>No Requests yet? Find and connect with other alumni to build your network!</p>
                        <img src='../assets/images/add-user.png' width='55px' >
                    </div>
                    ";
                } else {
                    while ($getRequest = mysqli_fetch_assoc($getRequest_query)) {
                        $name = $getRequest['First_Name'] . " " . $getRequest['Last_Name'];
                        $pfp = $getRequest['pfp'];
                        $UID = $getRequest['User_id'];
                        $getBatchID_query = mysqli_query($con, "SELECT * FROM alumni_details WHERE Alumni_id=$UID");
                        if (!$getBatchID_query) {
                            echo "Error: " . mysqli_error($con);
                            exit();
                        }
                        $getBatchID = mysqli_fetch_assoc($getBatchID_query);
                        $BID = $getBatchID['BatchID'];
                        echo '<div class="alumni-box">
                            <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                            <div class="alumni-info">
                                <p class="alumni-name">' . $name . '</p>
                                <p class="alumni-detail">Batch ID:' . $BID . '</p>
                                <button class="connect-button">Cancel</button>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
        <script>
            function showTab(tabId, event) {
                var tabs = document.getElementsByClassName('tab-content');
                for (var i = 0; i < tabs.length; i++) {
                    tabs[i].style.display = 'none';
                }
                document.getElementById(tabId).style.display = 'flex';

                var tabButtons = document.getElementsByClassName('tab');
                for (var i = 0; i < tabButtons.length; i++) {
                    tabButtons[i].classList.remove('active');
                }
                event.currentTarget.classList.add('active');
            }

            function acceptInvite(userId, alumniId) {
                $.ajax({
                    type: 'POST',
                    url: '../php/accept_invite.php',
                    data: {
                        user_id: userId,
                        alumni_id: alumniId
                    },
                    success: function (response) {
                        alert('Friend request accepted!');
                        location.reload(); // Reload the page after successful update
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            function sendInvite(userId, alumniId) {
                $.ajax({
                    type: 'POST',
                    url: '../php/send_invite.php',
                    data: {
                        user_id: userId,
                        alumni_id: alumniId
                    },
                    success: function (response) {
                        alert('Friend request Sent!');
                        $("#friends").load(" #friends > *");
                        $("#alumni-info").load(" #alumni-info > *");
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
        </script>
    <?php } ?>
</body>

</html>