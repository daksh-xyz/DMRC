<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/ProfileStyles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <title>Profile Page</title>
</head>

<body>
    <?php
    include ("../php/config.php");
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
    } else {
        $id = $_SESSION['id'];

        if (isset($_POST["pfpUpdate"])) {
            if ($_FILES["image"]["error"] == 4) {
                echo
                    "<script> alert('Image Does Not Exist'); </script>"
                ;
            } else {
                $fileName = $_FILES["image"]["name"];
                $fileSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $fileName);
                $imageExtension = strtolower(end($imageExtension));
                if (!in_array($imageExtension, $validImageExtension)) {
                    echo
                        "
              <script>
                alert('Invalid Image Extension');
              </script>
              ";
                } else if ($fileSize > 1000000) {
                    echo
                        "
              <script>
                alert('Image Size Is Too Large');
              </script>
              ";
                } else {
                    $newImageName = uniqid();
                    $newImageName .= '.' . $imageExtension;

                    move_uploaded_file($tmpName, '../assets/userpfp/' . $newImageName);
                    $query = "UPDATE alumni SET pfp='$newImageName' WHERE Alumni_id=$id";
                    mysqli_query($con, $query);
                    echo
                        "
              <script type='text/javascript'>
                alert('Profile Picture Updated!');
                window.location.href = 'profile.php';
              </script>
              ";
                }
            }
        }
        if (isset($_POST["submit"])) {
            $fullname = $_POST['name'];
            $fullname = explode(" ", $fullname, 2);
            $fname = $fullname[0];
            $lname = $fullname[1];
            $dob = $_POST['dob'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $district = $_POST['district'];
            $state = $_POST['state'];
            $pcode = $_POST['pcode'];
            $mobile = $_POST['mobile'];
            $BID = $_POST['BID'];
            $dept = $_POST['dept'];
            $jDate = $_POST['jDate'];
            $lDate = $_POST['lDate'];
            $UAN = $_POST['UAN'];
            $PF = $_POST['PF'];
            $PAN = $_POST['PAN'];
            $PNum = $_POST['PNum'];
            $cEmployment = $_POST['cEmployment'];
            $fb = $_POST['Facebook'];
            $twit = $_POST['Twitter'];
            $lin = $_POST['LinkedIn'];
            $ig = $_POST['Instagram'];
            $Alumni_edit_query = mysqli_query($con, "UPDATE alumni SET First_Name='$fname', Last_Name='$lname',DOB='$dob', Mobile='$mobile',Address='$address',District='$district',City='$city',State='$state',Pincode='$pcode',Username='$username',Email='$email',Password='$password' where Alumni_id=$id") or die("error occurred");
            $Detail_edit_query = mysqli_query($con, "UPDATE alumni_details SET BatchID='$BID',Department='$dept',UAN='$UAN',PF='$PF',Pension_Number='$PNum',PAN='$PAN',Join_Date='$jDate',Last_date='$lDate', CurrentEmployment='$cEmployment' WHERE Alumni_id=$id");
            $Socials_edit_query = mysqli_query($con, "UPDATE alumni_socials SET Facebook='$fb', Twitter='$twit', LinkedIn='$lin', Instagram='$ig' WHERE Alumni_id=$id");
            header("Location: profile.php");
        } else {
            $getAlumniData = "SELECT * FROM alumni a LEFT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id WHERE a.Alumni_id= $id UNION SELECT * FROM alumni a RIGHT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id WHERE ad.Alumni_id = $id;";
            $AlumniData = mysqli_query($con, $getAlumniData);
            $getAlumniSocials = mysqli_query($con, "SELECT * FROM alumni a JOIN alumni_socials asoc ON a.Alumni_id=asoc.Alumni_id WHERE a.Alumni_id=$id");
            $AlumniDataResult = mysqli_fetch_assoc($AlumniData);
            $AlumniSocials = mysqli_fetch_assoc($getAlumniSocials);
            $name = $AlumniDataResult['First_Name'] . " " . $AlumniDataResult['Last_Name'];
            $dob = $AlumniDataResult['DOB'];
            $username = $AlumniDataResult['Username'];
            $email = $AlumniDataResult['Email'];
            $password = $AlumniDataResult['Password'];
            $address = $AlumniDataResult['Address'];
            $city = $AlumniDataResult['City'];
            $district = $AlumniDataResult['District'];
            $state = $AlumniDataResult['State'];
            $pcode = $AlumniDataResult['Pincode'];
            $mobile = $AlumniDataResult['Mobile'];
            $pfp = $AlumniDataResult['pfp'];
            $BID = $AlumniDataResult['BatchID'];
            $UAN = $AlumniDataResult['UAN'];
            $PF = $AlumniDataResult['PF'];
            $PAN = $AlumniDataResult['PAN'];
            $PNum = $AlumniDataResult['Pension_Number'];
            $dept = $AlumniDataResult['Department'];
            $jDate = $AlumniDataResult['Join_Date'];
            $lDate = $AlumniDataResult['Last_date'];
            $cEmployment = $AlumniDataResult['CurrentEmployment'];
            $fb = $AlumniSocials['Facebook'];
            $twit = $AlumniSocials['Twitter'];
            $lin = $AlumniSocials['LinkedIn'];
            $ig = $AlumniSocials['Instagram'];
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
                        <a href="Socialize.php" class="link">Socialize</a>
                        <a class="link" href="home.php">Home</a>
                        <a id="logout" class="link" href="../php/logout.php">Logout</a>
                    </div>
                </div>
            </header>
            <div class="space"></div>
            <div class="pcenter">
                <div class="profile-container">
                    <h1>My Profile</h1>
                    <div class="tabs">
                        <button class="tab active" onclick="showTab('personal-details')">Personal Details</button>
                        <button class="tab" onclick="showTab('contact-details')">Contact Details</button>
                        <button class="tab" onclick="showTab('employment-info')">Alumni Information</button>
                        <button class="tab" onclick="showTab('Socials')">Socials</button>
                    </div>

                    <div id="personal-details" class="tab-content">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="profile-info">
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
                                        Followers
                                        <?php
                                        $stmt = $con->prepare("SELECT COUNT(Alumni_id) AS Followers FROM connections WHERE Alumni_id = ? AND Alumni_id != User_id;");
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $getFollowers_query = $stmt->get_result();
                                        $getFollowers = $getFollowers_query->fetch_assoc();
                                        $followers = $getFollowers['Followers'];
                                        echo "<p id='count'>$followers</p>";
                                        ?>
                                    </div>
                                    <div id="following">
                                        Following
                                        <?php
                                        $stmt = $con->prepare("SELECT COUNT(Alumni_id) AS Followers FROM connections WHERE User_id = ? AND Alumni_id != User_id;");
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $getFollowing_query = $stmt->get_result();
                                        $getFollowing = $getFollowing_query->fetch_assoc();
                                        $following = $getFollowing['Followers'];
                                        echo "<p id='count'>$following</p>";
                                        ?>
                                    </div>
                                </div>
                                <input type="submit" name="pfpUpdate" value="Update Profile Picture" class="pfpUpdate">
                                <div class="pcenter">
                                    <input type="text" name="name" id="name" value="<?php echo $name ?>">
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date Of Birth:</label>
                                    <input type="date" name="dob" id="dob" value="<?php echo $dob ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" name="username" id="username" value="<?php echo $username ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Id:</label>
                                    <input type="email" name="email" id="email" value="<?php echo $email ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Password">Password:</label>
                                    <input type="password" name="password" id="password" value="<?php echo $password ?>">
                                </div>
                                <div class="pcenter">
                                    <input class="continue-btn" onclick="cycleTab(1)" value="Continue" readonly>
                                </div>
                            </div>
                    </div>

                    <div id="contact-details" class="tab-content" style="display: none;">
                        <div class="profile-info">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" value="<?php echo $address ?>">
                            </div>
                            <div class="col form-group">
                                <div class="row">
                                    <label for="district">District:</label>
                                    <input type="text" id="dist" name="district" value="<?php echo $district ?>" required>
                                </div>
                                <div class="row">
                                    <label for="city">City:</label>
                                    <input type="text" id="city" name="city" value="<?php echo $city ?>" required>
                                </div>
                            </div>
                            <div class="col form-group">
                                <div class="row">
                                    <label for="state">State:</label>
                                    <input type="text" id="state" name="state" value="<?php echo $state ?>" required>
                                </div>
                                <div class="row">
                                    <label for="pincode">Pincode:</label>
                                    <input type="number" id="pcode" name="pcode" value="<?php echo $pcode ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country">Residence Country:</label>
                                <input type="text" id="country" value="India" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mobile-number">Mobile Number:</label>
                                <div class="phone-input">
                                    <input type="text" id="mobile-code" value="+91" readonly>
                                    <input type="text" id="mobile-number" name="mobile" value="<?php echo $mobile ?>">
                                </div>
                            </div>
                            <input class="back-btn" onclick="cycleTab(0)" value="Back" readonly>
                            <input class="continue-btn" onclick="cycleTab(2)" value="Continue" readonly>
                        </div>
                    </div>

                    <div id="employment-info" class="tab-content" style="display: none;">
                        <div class="profile-info">
                            <div class="col">
                                <div class="form-group">
                                    <label for="Date of Joining">Date Of Joining:</label>
                                    <input type="date" name="jDate" id="jDate" value="<?php echo $jDate ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Last Date">Last Working Date:</label>
                                    <input type="date" name="lDate" id="lDate" value="<?php echo $lDate ?>">
                                </div>
                            </div>
                            <div class="col form-group">
                                <div class="row">
                                    <label for="Batch ID">Batch ID:</label>
                                    <input type="text" name="BID" id="BID" value="<?php echo $BID ?>">
                                </div>
                                <div class="row">
                                    <label for="Department">Department:</label>
                                    <input type="text" name="dept" id="Dept" value="<?php echo $dept ?>">
                                </div>
                            </div>
                            <div class="col form-group">
                                <div class="row">
                                    <label for="UAN">UAN Number:</label>
                                    <input type="text" name="UAN" id="UAN" value="<?php echo $UAN ?>">
                                </div>
                                <div class="row">
                                    <label for="PF Number">PF Number:</label>
                                    <input type="text" name="PF" id="PF" value="<?php echo $PF ?>">
                                </div>
                            </div>
                            <div class="col form-group">
                                <div class="row">
                                    <label for="PAN">PAN:</label>
                                    <input type="text" name="PAN" id="PAN" value="<?php echo $PAN ?>">
                                </div>
                                <div class="row">
                                    <label for="Pension Number">Pension Number:</label>
                                    <input type="text" name="PNum" id="PNum" value="<?php echo $PNum ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Current Employer">Current Employer:</label>
                                <input type="text" name="cEmployment" id="cEmployment"
                                    placeholder="Name of company with designation" value="<?php echo $cEmployment ?>">
                            </div>
                            <input class="back-btn" onclick="cycleTab(1)" value="Back" readonly>
                            <input class="continue-btn" onclick="cycleTab(3)" value="Continue" readonly>
                        </div>
                    </div>
                    <div id="Socials" class="tab-content" style="display: none;">
                        <div class="profile-info">
                            <div class="form-group">
                                <label for="LinkedIn">Facebook Username:</label>
                                <input type="text" name="Facebook" id="Facebook" value="<?php echo $fb ?>">
                            </div>
                            <div class="form-group">
                                <label for="Twitter">Twitter Username:</label>
                                <input type="text" name="Twitter" id="Twitter" value="<?php echo $twit ?>">
                            </div>
                            <div class="form-group">
                                <label for="LinkedIn">LinkedIn Username:</label>
                                <input type="text" name="LinkedIn" id="LinkedIn" value="<?php echo $lin ?>">
                            </div>
                            <div class="form-group">
                                <label for="Instagram">Instagram Username:</label>
                                <input type="text" name="Instagram" id="Instagram" value="<?php echo $ig ?>">
                            </div>
                            <input class="back-btn" onclick="cycleTab(2)" value="Back" readonly>
                            <input type="submit" name="submit" class="continue-btn" onclick="cycleTab(3)" value="Continue"
                                readonly>
                        </div>
                    </div>
                    </form>
                </div>
            <?php } ?>
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
            }

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