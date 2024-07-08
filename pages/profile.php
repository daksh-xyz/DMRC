<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/ProfileStyles.css">
    <title>Profile Page</title>
</head>

<body>
    <?php
    session_start();
    include ("../php/config.php");
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
    }
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
        $Alumni_edit_query = mysqli_query($con, "UPDATE alumni SET First_Name='$fname', Last_Name='$lname',DOB='$dob', Mobile='$mobile',Address='$address',District='$district',City='$city',State='$state',Pincode='$pcode',Username='$username',Email='$email',Password='$password' where Alumni_id=$id") or die("error occurred");
        $Detail_edit_query = mysqli_query($con, "UPDATE alumni_details SET BatchID='$BID',Department='$dept',UAN='$UAN',PF='$PF',Pension_Number='$PNum',PAN='$PAN',Join_Date='$jDate',Last_date='$lDate' WHERE Alumni_id=$id");
        mysqli_query($con, $Alumni_edit_query);
        mysqli_query($con, $Detail_edit_query);
        header("Location: profile.php");
    } else {
        $getAlumniData = "SELECT * FROM alumni a LEFT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id UNION SELECT * FROM alumni a RIGHT JOIN alumni_details ad ON a.Alumni_id = ad.Alumni_id";
        $AlumniData = mysqli_query($con, $getAlumniData);
        $AlumniDataResult = mysqli_fetch_assoc($AlumniData);
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
        ?>

        <header>
            <div class="head">
                <img src="../assets/images/logo.png" width="100px" height="39px">
                <div>
                    <a href="Socialize.php" class="link">Socialize</a>
                    <a class="link" href="home.php">Home</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>
        <div class="center">
            <div class="profile-container">
                <h1>My Profile</h1>
                <div class="tabs">
                    <button class="tab active" onclick="showTab('personal-details')">Personal Details</button>
                    <button class="tab" onclick="showTab('contact-details')">Contact Details</button>
                    <button class="tab" onclick="showTab('employment-info')">Alumni Information</button>
                </div>

                <div id="personal-details" class="tab-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="profile-info">
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
                        <div class="col form-group">
                            <div class="row">
                                <label for="Join Date">Date of Joining:</label>
                                <input type="date" name="jDate" id="jDate" value="<?php echo $jDate ?>">
                            </div>
                            <div class="row">
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
                        <div class="form-group">
                            <label for="PAN">PAN:</label>
                            <input type="text" name="PAN" id="PAN" value="<?php echo $PAN ?>">
                        </div>
                        <div class="form-group">
                            <label for="Pension Number">Pension Number:</label>
                            <input type="text" name="PNum" id="PNum" value="<?php echo $PNum ?>">
                        </div>
                        <input class="back-btn" onclick="cycleTab(1)" value="Back" readonly>
                        <input type="submit" name="submit" class="continue-btn" onclick="cycleTab(2)" value="Continue"
                            readonly>
                    </div>
                    </form>
                </div>
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
    </script>
</body>

</html>