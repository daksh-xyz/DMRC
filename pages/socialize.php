<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/SocialStyle.css">
    <title>DMRC | Socialize</title>
</head>

<body>
    <?php
    session_start();
    include ("../php/config.php");
    if (!isset($_SESSION["id"])) {
        header("Location: ../index.php");
    } else {
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
            echo "<script>window.location.href = 'profile.php';</script>";
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
                <button class="tab active" onclick="showTab('alumni-grid')">Personal Details</button>
                <button class="tab" onclick="showTab('contact-details')">Contact Details</button>
                <button class="tab" onclick="showTab('employment-info')">Alumni Information</button>
            </div>
            <div class="alumni-grid">
                <?php
                $id = $_SESSION['id'];
                $getFriends_query = mysqli_query($con, "SELECT * FROM alumni a JOIN connections c ON a.Alumni_id = c.User_id WHERE c.Alumni_id= $id;");
                while ($getFriends = mysqli_fetch_assoc($getFriends_query)) {
                    $name = $getFriends['First_Name'] . " " . $getFriends['Last_Name'];
                    $pfp = $getFriends['pfp'];
                    $UID = $getFriends['User_id'];
                    $getBatchID_query = mysqli_query($con, "SELECT * FROM alumni_details WHERE Alumni_id=$UID");
                    $getBatchID = mysqli_fetch_assoc($getBatchID_query);
                    $BID = $getBatchID['BatchID'];
                    echo '<div class="alumni-box">
                    <img src="../assets/userpfp/' . $pfp . '" alt="Profile Picture" class="profile-pic">
                    <div class="alumni-info">
                        <p class="alumni-name">' . $name . '</p>
                        <p class="alumni-detail">Batch ID:' . $BID . '</p>
                        <button class="connect-button">Connect</button>
                    </div>
                </div>';
                }
                ?>
            </div>
        </div>
        <script>
            function cycleTab(count) {
                var tabs = document.getElementsByClassName('tab-content');
                var tabNum = count;
                for (var i = 0; i < tabs.length; i++) {
                    tabs[i].style.display = 'none';
                }
                tabs[tabNum].style.display = 'block';

                var tabButtons = document.getElementsByClassName('tab');
                for (var i = 0; i < tabButtons.length; i++) {
                    tabButtons[i].classList.remove('active');
                }
                tabButtons[tabNum].classList.add('active');
            }

            function showTab(tabId) {
                var tabs = document.getElementsByClassName('tab-content');
                for (var i = 0; i < tabs.length; i++) {
                    tabs[i].style.display = 'none';
                }
                document.getElementById(tabId).style.display = 'block';

                var tabButtons = document.getElementsByClassName('tab');
                for (var i = 0; i < tabButtons.length; i++) {
                    tabButtons[i].classList.remove('active');
                }
                event.currentTarget.classList.add('active');

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