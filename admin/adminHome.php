<?php session_start();
include ("../php/config.php");
if (!isset($_SESSION['AdminId'])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../src/AdminStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Admin Home</title>
</head>

<body>
    <header>
        <div class="head">
            <a href="home.php"><img src="../assets/images/logo.png" width="100px" height="39px"></a>
            <div>
                <div class="off-screen-menu">
                    <div class="top">
                        <ul>
                            <li><a href="adminHome.php">Dashboard</a></li>
                            <li><a href="manage.php">Manage users</a></li>
                        </ul>
                    </div>
                    <div class="bottom">
                        <ul>
                            <li><a href="../php/AdminLogout.php" id="menu-logout">Logout</a></li>
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
                <a href="adminHome.php" class="link">Dashboard</a>
                <a class="link" href="manage.php">Manage Users</a>
                <a id="logout" class="link" href="../php/AdminLogout.php">Logout</a>
            </div>
        </div>
    </header>
    <div class="space"></div>
    <div class="mainGrid">
        <div class="chart">
            <h1>Alumni Registrations</h1>
            <?php
            $stmt = $con->prepare("SELECT COUNT(Alumni_id) AS AlumniNumber FROM alumni");
            $stmt->execute();
            $result = $stmt->get_result();
            $getAlumniNumber = $result->fetch_assoc()['AlumniNumber'];
            echo "Total Alumnis: $getAlumniNumber";
            include ("../util/NewRegistrations.php");
            ?>
        </div>
        <div class="chart notification" id="notif">
            <h1>Notifications</h1>
            <table class="notif" width="80%" align="center">
                <?php
                $stmt = $con->prepare("SELECT ad.SenderID, a.First_Name, a.Last_Name, a.pfp, TIMESTAMPDIFF(SECOND, requestTime, NOW()) AS time_elapsed FROM alumni_docs ad JOIN alumni a ON a.Alumni_id = ad.SenderID WHERE F16Status='Requested' OR pSlipStatus='Requested' OR SAnnuationStatus='Requested' OR ServiceCertificateStatus='Requested' OR ReleaseLetterStatus='Requested'");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($getNotification = $result->fetch_assoc()) {
                    $pfp = $getNotification['pfp'];
                    $SenderID = $getNotification['SenderID'];
                    $name = $getNotification['First_Name'] . " " . $getNotification['Last_Name'];
                    $time = $getNotification['time_elapsed'];
                    $time = (int) $time;
                    if ($time >= 3600) {
                        $time = (int) ($time / 3600);
                        $time .= "h";
                    } elseif ($time >= 86400) {
                        $time = (int) ($time / 86400);
                        $time .= "d";
                    } elseif ($time >= 60) {
                        $time = (int) ($time / 60);
                        $time .= "m";
                    } else {
                        $time .= "s";
                    }
                    echo '
                        <tr class="notifRow">
                            <td width="10%"><img src="../assets/userpfp/' . $pfp . '" class="profile-pic-small"></td>
                            <td id="name"><a href="documentUpload.php?SenderID=' . $SenderID . '" onclick="showfriendView(\'iframe-container1\', event); showfriendView(\'friendView1\', event)" id="friendProfile" target="iframe_b">' . $name . '</a></td>
                            <td id="message">requested a document</td>
                            <td id="time" width="5%">' . $time . '</td>
                            <td class="X" width="10%"><a href="#" onclick="deleteNotif(' . $SenderID . ')"><img src="../assets/images/delete.png" alt="X" width="25px"></a></td>
                        </tr>';
                }
                ?>
            </table>
        </div>
    </div>
    <div class="subGrid">
        <h1>Recent Activities</h1>
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Activity</th>
                    <th>User</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $con->prepare("SELECT *, DATE(RegisterTime) AS RegisterTime FROM alumni ORDER BY RegisterTime DESC");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($getAlumni = $result->fetch_assoc()) {
                    $UID = $getAlumni['Alumni_id'];
                    $fname = $getAlumni['First_Name'];
                    $lname = $getAlumni['Last_Name'];
                    $rdate = $getAlumni['RegisterTime'];
                    echo '
                <tr style="text-align: center;">
                    <td> Registered </td>
                    <td><a href="alumniView.php?uid=' . $UID . '" onclick="showfriendView(\'iframe-container\', event); showfriendView(\'friendView\', event)" id="friendProfile" target="iframe_a">' . $fname . ' ' . $lname . '</a></td>
                    <td>' . $rdate . ' </td>
                </tr>';
                }
                ?>
            </tbody>
        </table>
        <div id="iframe-container" style="display:none;">
            <iframe src="alumniView.php" frameborder="0" name="iframe_a" title="frame" id="friendView"
                style="display:none;"></iframe>
        </div>
        <div id="iframe-container1" style="display:none;">
            <iframe src="documentUpload.php" frameborder="0" name="iframe_b" title="frame" id="friendView1"
                style="display:none;"></iframe>
        </div>
    </div>

    <script>
        document.querySelector('.ham-menu').addEventListener('click', () => {
            document.querySelector('.ham-menu').classList.toggle('active');
            document.querySelector('.off-screen-menu').classList.toggle('active');
        });

        function showfriendView(tabId, event) {
            document.getElementById(tabId).style.display = 'block';
        }

        function deleteNotif(alumniId) {
            $.ajax({
                type: 'POST',
                url: '../php/deleteRequest.php',
                data: { alumni_id: alumniId },
                success: function (response) {
                    $("#notif").load(" #notif > *");
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
</body>

</html>