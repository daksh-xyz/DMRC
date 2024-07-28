<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/ProfileStyles.css">
    <link rel="stylesheet" href="../src/friendView.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <title>Profile</title>
</head>

<body>
    <?php
    include ("../php/config.php");
    if (!isset($_GET['uid'])) {
        header("socialize.php");
    } else {
        $uid = $_GET['uid'];
        $stmt = $con->prepare("SELECT * FROM alumni a LEFT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id WHERE a.Alumni_id= ? UNION SELECT * FROM alumni a RIGHT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id WHERE ad.Alumni_id = ?;");
        $stmt->bind_param("ii", $uid, $uid);
        $stmt->execute();
        $getAlumniData_query = $stmt->get_result();
        $getAlumniData = $getAlumniData_query->fetch_assoc();
        $stmt = $con->prepare("SELECT * FROM alumni a LEFT JOIN alumni_socials asoc ON a.Alumni_id=asoc.Alumni_id WHERE a.Alumni_id=?");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $getAlumniSocials_query = $stmt->get_result();
        $getAlumniSocials = $getAlumniSocials_query->fetch_assoc();
        $name = $getAlumniData['First_Name'] . " " . $getAlumniData['Last_Name'];
        $dob = $getAlumniData['DOB'];
        $username = $getAlumniData['Username'];
        $email = $getAlumniData['Email'];
        $password = $getAlumniData['Password'];
        $address = $getAlumniData['Address'];
        $city = $getAlumniData['City'];
        $district = $getAlumniData['District'];
        $state = $getAlumniData['State'];
        $pcode = $getAlumniData['Pincode'];
        $mobile = $getAlumniData['Mobile'];
        $pfp = $getAlumniData['pfp'];
        $BID = $getAlumniData['BatchID'];
        $UAN = $getAlumniData['UAN'];
        $PF = $getAlumniData['PF'];
        $PAN = $getAlumniData['PAN'];
        $PNum = $getAlumniData['Pension_Number'];
        $dept = $getAlumniData['Department'];
        $jDate = $getAlumniData['Join_Date'];
        $lDate = $getAlumniData['Last_date'];
        $cEmployment = $getAlumniData['CurrentEmployment'];
        $fb = $getAlumniSocials['Facebook'];
        $twit = $getAlumniSocials['Twitter'];
        $lin = $getAlumniSocials['LinkedIn'];
        $ig = $getAlumniSocials['Instagram'];
        ?>
        <div class="pcenter">
            <div class="profile-container">
                <div class="profile-info">
                    <h2><?php echo $name ?></h2>
                    <div class="connection-info">
                        <div class="profile-pic">
                            <label>
                                <input type="file" name="image" style="display:none;" />
                                <img src="../assets/userpfp/<?php if ($pfp != '') {
                                    echo $pfp;
                                } else {
                                    echo "user.png";
                                } ?>" class="user">
                            </label>
                        </div>
                        <div id="followers">
                            Followers <br><br>
                            <?php
                            $stmt = $con->prepare("SELECT COUNT(Alumni_id) AS Followers FROM connections WHERE Alumni_id = ? AND Alumni_id != User_id;");
                            $stmt->bind_param("i", $uid);
                            $stmt->execute();
                            $getFollowers_query = $stmt->get_result();
                            $getFollowers = $getFollowers_query->fetch_assoc();
                            $followers = $getFollowers['Followers'];
                            echo "<p id='count'>$followers</p>";
                            ?>
                        </div>
                        <div id="following">
                            Following <br><br>
                            <?php
                            $stmt = $con->prepare("SELECT COUNT(Alumni_id) AS Followers FROM connections WHERE User_id = ? AND Alumni_id != User_id;");
                            $stmt->bind_param("i", $uid);
                            $stmt->execute();
                            $getFollowing_query = $stmt->get_result();
                            $getFollowing = $getFollowing_query->fetch_assoc();
                            $following = $getFollowing['Followers'];
                            echo "<p id='count'>$following</p>";
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="<?php echo $username ?>" readonly>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="dob">Date of Leaving:</label>
                            <input type="date" name="lDate" id="lDate" value="<?php echo $lDate ?>" readonly>
                        </div>
                        <div class="row form-group">
                            <label for="Department">Department:</label>
                            <input type="text" name="dept" id="Dept" value="<?php echo $dept ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row form-group">
                            <label for="email">Mobile:</label>
                            <input type="text" name="mobile" id="mobile" value="<?php echo $mobile ?>" readonly>
                        </div>
                        <div class="row form-group">
                            <label for="email">Current Employer:</label>
                            <input type="text" name="cEmployment" id="cEmployment" value="<?php echo $cEmployment ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="rounded-social-buttons">
                        <a class="social-button facebook" href="https://www.facebook.com/<?php echo $fb ?>"
                            target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="social-button twitter" href="https://www.twitter.com/<?php echo $twit ?>"
                            target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="social-button linkedin" href="https://www.linkedin.com/<?php echo $lin ?>"
                            target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a class="social-button instagram" href="https://www.instagram.com/<?php echo $ig ?>"
                            target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div>
                        <input class="continue-btn"
                            onclick="window.location.href= 'documentUpload.php?SenderID=<?php echo $uid ?>'"
                            value="UPLOAD DOCUMENTS" readonly>
                        <input class="continue-btn" onclick="closeWin()" value="CLOSE" readonly>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script>
        function closeWin()   // Tested Code
        {
            var someIframe = window.parent.document.getElementById('friendView');
            var iframe_container = window.parent.document.getElementById('iframe-container');
            iframe_container.style.display = "None";
            someIframe.style.display = "None";
        }
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
        crossorigin="anonymous"></script>

</body>

</html>