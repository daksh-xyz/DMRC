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
    <link rel="stylesheet" href="../src/manageStyle.css">
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
                            <li><a href="manage.php">Manage Users</a></li>
                        </ul>
                    </div>
                    <div class="bottom">
                        <ul>
                            <li><a href="../php/AdminLogout.php" id="menu-logout"><img src="">Logout</a></li>
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
    <div class="center">
        <div class="subGrid">
            <table class="fl-table">
                <thead>
                    <th>Activity</th>
                    <th>User</th>
                    <th>Retiring Date</th>
                    <th>Date</th>
                </thead>
                <?php
                $stmt = $con->prepare("SELECT *,DATE(RegisterTime) AS RegisterTime FROM alumni a JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id ORDER BY RegisterTime DESC");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($getAlumni = $result->fetch_assoc()) {
                    $aid = $getAlumni['Alumni_id'];
                    $fname = $getAlumni['First_Name'];
                    $lname = $getAlumni['Last_Name'];
                    $ldate = $getAlumni['Last_date'];
                    $rdate = $getAlumni['RegisterTime'];
                    echo '<tr style="text-align: center;">
                    <td> Registered </td>
                    <td><a href="alumniView.php?uid=' . $aid . '" onclick="showfriendView(\'iframe-container\', event); showfriendView(\'friendView\', event)" id="friendProfile" target="iframe_a">' . $fname . ' ' . $lname . '</a></td>
                    <td>' . $ldate . '</td>
                    <td>' . $rdate . '</td>
                </tr>';
                }
                ?>
            </table>
            <div id="iframe-container" style="display:none;">
                <iframe src="alumniView.php" frameborder="0" name="iframe_a" title="frame" id="friendView"
                    style="display:none;"></iframe>
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

        function showfriendView(tabId, event) {
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</body>

</html>