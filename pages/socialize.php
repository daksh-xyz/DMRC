<?php session_start();
$uids = [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/friendView.css">
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

        // Using prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM alumni_details WHERE Alumni_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $qresult = $stmt->get_result();

        if (!$qresult) {
            echo "Error: " . $con->error;
            exit();
        }
        $row = $qresult->fetch_assoc();
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
            <div class="tabs">
                <button class="tab active" onclick="showTab('friends', event)">Connections</button>
                <button class="tab" onclick="showTab('invitation', event)">Incoming Requests</button>
                <button class="tab" onclick="showTab('requests', event)">Outgoing Requests</button>
            </div>
            <div id="friends" class="alumni-grid tab-content">
                <h3 id="recommendText">Suggested Alumni:</h3>
                <div class="recommendations">
                    <?php
                    $stmt = $con->prepare("SELECT a.*, ad.*, c.*
                    FROM alumni a
                    JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id
                    JOIN connections c ON a.Alumni_id = c.Alumni_id
                    WHERE c.Alumni_id != ? AND c.FriendshipStatus = 0
                    AND a.Alumni_id NOT IN (
                        SELECT c.User_id FROM alumni a JOIN connections c ON a.Alumni_id = c.User_id WHERE c.Alumni_id = ? AND c.FriendshipStatus=1
                    )
                    GROUP BY a.Alumni_id;");
                    $stmt->bind_param("ii", $id, $id);
                    $stmt->execute();
                    $getrecommendations_query = $stmt->get_result();

                    if (!mysqli_num_rows($getrecommendations_query)) {
                        echo "<div class='message'>No suggested alumnis at this moment</div>";
                    }
                    if (!$getrecommendations_query) {
                        echo "Error: " . $con->error;
                        exit();
                    } else {
                        while ($getrecommendations = $getrecommendations_query->fetch_assoc()) {
                            $name = $getrecommendations['First_Name'] . " " . $getrecommendations['Last_Name'];
                            $pfp = $getrecommendations['pfp'];
                            $AID = $id;
                            $UID = $getrecommendations['User_id'];
                            echo '<div class="alumni-box">
                                <img src="../assets/userpfp/' . htmlspecialchars($pfp, ENT_QUOTES, 'UTF-8') . '" alt="Profile Picture" class="profile-pic">
                                <div class="alumni-info">
                                    <p class="alumni-name">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>
                                    <button class="connect-button" onclick="sendInvite(' . htmlspecialchars($UID, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($AID, ENT_QUOTES, 'UTF-8') . ')">Connect</button>
                                </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <div class="alumni-grid">
                    <?php
                    $stmt = $con->prepare("SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.User_id WHERE c.Alumni_id = ? AND c.FriendshipStatus=1;");
                    $stmt->bind_param("i", $id);
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
                                <img src='../assets/images/add-user.png' width='55px' >
                            </div>
                        ";
                    } else {
                        $countID = 0;
                        while ($getFriends = $getFriends_query->fetch_assoc()) {
                            $name = $getFriends['First_Name'] . " " . $getFriends['Last_Name'];
                            $pfp = $getFriends['pfp'];
                            $AID = $getFriends['Alumni_id'];
                            $UID = $getFriends['User_id'];
                            array_push($uids, $UID);
                            $stmt = $con->prepare("SELECT * FROM alumni_details WHERE Alumni_id = ?");
                            $stmt->bind_param("i", $UID);
                            $stmt->execute();
                            $getBatchID_query = $stmt->get_result();
                            if (!$getBatchID_query) {
                                echo "Error: " . $con->error;
                                exit();
                            }
                            $getBatchID = $getBatchID_query->fetch_assoc();
                            $BID = $getBatchID['BatchID'];
                            echo '<div class="container"><a href="friendProfile.php?uid=' . $UID . '" onclick="showfriendView(\'iframe-container\', event); showfriendView(\'friendView\', event)" id="friendProfile" target="iframe_a"><div class="alumni-box">
                                <img src="../assets/userpfp/' . htmlspecialchars($pfp, ENT_QUOTES, 'UTF-8') . '" alt="Profile Picture" class="profile-pic">
                                <div class="alumni-info">
                                    <p class="alumni-name">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>
                                    <p class="alumni-detail">Batch ID:' . htmlspecialchars($BID, ENT_QUOTES, 'UTF-8') . '</p>
                                    </div>
                                    </a>
                                    <button class="connect-button" onclick="unfollowAlumni(' . htmlspecialchars($UID, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($AID, ENT_QUOTES, 'UTF-8') . ')">Unfriend</button>
                            </div>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <div id="iframe-container" style="display:none;">
                    <iframe src="friendProfile.php" frameborder="0" name="iframe_a" title="frame" id="friendView"
                        style="display:none;"></iframe>
                </div>
            </div>
            <div id="invitation" class="alumni-grid tab-content" style="display: none;">
                <?php
                $stmt = $con->prepare("SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.Alumni_id WHERE c.Alumni_id != ? AND c.User_id= ? AND c.FriendshipStatus=0;");
                $stmt->bind_param("ii", $id, $id);
                $stmt->execute();
                $getInvites_query = $stmt->get_result();
                if (!$getInvites_query) {
                    echo "Error: " . $con->error;
                    exit();
                }
                if (!mysqli_num_rows($getInvites_query)) {
                    echo "
                        <div class='empty'>
                            <p>You don't have any pending requests at the moment.</p>
                            <img src='../assets/images/add-user.png' width='55px'>
                        </div>
                    ";
                } else {
                    while ($getInvites = $getInvites_query->fetch_assoc()) {
                        $name = $getInvites['First_Name'] . " " . $getInvites['Last_Name'];
                        $pfp = $getInvites['pfp'];
                        $AID = $getInvites['Alumni_id'];
                        $UID = $getInvites['User_id'];
                        $stmt = $con->prepare("SELECT * FROM alumni_details WHERE Alumni_id = ?");
                        $stmt->bind_param("i", $UID);
                        $stmt->execute();
                        $getBatchID_query = $stmt->get_result();
                        if (!$getBatchID_query) {
                            echo "Error: " . $con->error;
                            exit();
                        }
                        $getBatchID = $getBatchID_query->fetch_assoc();
                        $BID = $getBatchID['BatchID'];
                        echo '<div class="alumni-box">
                            <img src="../assets/userpfp/' . htmlspecialchars($pfp, ENT_QUOTES, 'UTF-8') . '" alt="Profile Picture" class="profile-pic">
                            <div class="alumni-info">
                                <p class="alumni-name">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>
                                <p class="alumni-detail">Batch ID:' . htmlspecialchars($BID, ENT_QUOTES, 'UTF-8') . '</p>
                                <button class="connect-button" onclick="acceptRequest(' . htmlspecialchars($UID, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($AID, ENT_QUOTES, 'UTF-8') . ')">Accept</button>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
            <div id="requests" class="alumni-grid tab-content" style="display: none;">
                <?php
                $stmt = $con->prepare("SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.User_id WHERE c.Alumni_id= ? AND c.User_id != ? AND c.FriendshipStatus=0;");
                $stmt->bind_param("ii", $id, $id);
                $stmt->execute();
                $getRequest_query = $stmt->get_result();
                if (!$getRequest_query) {
                    echo "Error: " . $con->error;
                    exit();
                }
                if (!mysqli_num_rows($getRequest_query)) {
                    echo "
                        <div class='empty'>
                            <p>You don't have any outgoing requests at the moment.</p>
                            <img src='../assets/images/add-user.png' width='55px'>
                        </div>
                    ";
                } else {
                    while ($getRequests = $getRequest_query->fetch_assoc()) {
                        $name = $getRequests['First_Name'] . " " . $getRequests['Last_Name'];
                        $pfp = $getRequests['pfp'];
                        $AID = $getRequests['Alumni_id'];
                        $UID = $getRequests['User_id'];
                        $stmt = $con->prepare("SELECT * FROM alumni_details WHERE Alumni_id = ?");
                        $stmt->bind_param("i", $UID);
                        $stmt->execute();
                        $getBatchID_query = $stmt->get_result();
                        if (!$getBatchID_query) {
                            echo "Error: " . $con->error;
                            exit();
                        }
                        $getBatchID = $getBatchID_query->fetch_assoc();
                        $BID = $getBatchID['BatchID'];
                        echo '<div class="alumni-box">
                            <img src="../assets/userpfp/' . htmlspecialchars($pfp, ENT_QUOTES, 'UTF-8') . '" alt="Profile Picture" class="profile-pic">
                            <div class="alumni-info">
                                <p class="alumni-name">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>
                                <p class="alumni-detail">Batch ID:' . htmlspecialchars($BID, ENT_QUOTES, 'UTF-8') . '</p>
                                <button class="connect-button" onclick="cancelRequest(' . htmlspecialchars($UID, ENT_QUOTES, 'UTF-8') . ', ' . htmlspecialchars($AID, ENT_QUOTES, 'UTF-8') . ')">Cancel Request</button>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    <?php } ?>
</body>
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

    function showfriendView(tabId, event) {
        document.getElementById(tabId).style.display = 'block';
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
                $("#requests").load(" #requests > *");
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function acceptRequest(userId, alumniId) {
        $.ajax({
            type: 'POST',
            url: '../php/accept_invite.php',
            data: {
                user_id: userId,
                alumni_id: alumniId
            },
            success: function (response) {
                alert('Friend request accepted!');
                $("#friends").load(" #friends > *");
                $("#invitation").load(" #invitation > *");
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function cancelRequest(userId, alumniId) {
        $.ajax({
            type: 'POST',
            url: '../php/unfollow.php',
            data: {
                user_id: userId,
                alumni_id: alumniId
            },
            success: function (response) {
                alert('Invite removed!');
                $("#requests").load(" #requests > *");
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function unfollowAlumni(userId, alumniId) {
        $.ajax({
            type: 'POST',
            url: '../php/unfollow.php',
            data: {
                user_id: userId,
                alumni_id: alumniId
            },
            success: function (response) {
                alert('Friend removed!');
                $("#friends").load(" #friends > *");
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

</html>