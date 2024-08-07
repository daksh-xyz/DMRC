<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>DMRC | Alumni Portal</title>
</head>

<body>
    <?php
    include ("php/config.php");
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $BID = null;
        $dept = null;
        $jDate = null;
        $lDate = null;
        $UAN = null;
        $PF = null;
        $PAN = null;
        $PNum = null;

        $result = mysqli_query($con, "SELECT * FROM alumni WHERE Username='$username' AND Password='$password' ") or die("Select Error");
        $adminResult = mysqli_query($con, "SELECT * FROM admin WHERE Username='$username' AND Password='$password' ") or die("Select Error");
        $row = mysqli_fetch_assoc($result);
        $adminRow = mysqli_fetch_assoc($adminResult);

        if (is_array($row) && !empty($row)) {
            $_SESSION['id'] = $row['Alumni_id'];
            $id = $_SESSION['id'];
            $verify_query = mysqli_query($con, "SELECT Alumni_id FROM alumni_details WHERE Alumni_id='$id' ");
            $socials_query = mysqli_query($con, "SELECT Alumni_id FROM alumni_socials WHERE Alumni_id='$id' ");
            if (mysqli_num_rows($verify_query) == 0) {
                $stmt = $con->prepare("INSERT INTO alumni_details(Alumni_id, BatchID, Department, UAN, PF, Pension_Number, PAN, Join_Date, Last_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($con->error));
                }
                // Bind the parameters
                $stmt->bind_param("sssssssss", $id, $BID, $dept, $jDate, $lDate, $UAN, $PF, $PAN, $PNum);

                if ($stmt->execute() === false) {
                    die('Execute failed: ' . htmlspecialchars($stmt->error));
                }
                $stmt->close();
            }
            if (mysqli_num_rows($socials_query) == 0) {
                $stmt = $con->prepare("INSERT INTO alumni_socials(Alumni_id) VALUES (?)");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($con->error));
                }
                // Bind the parameters
                $stmt->bind_param("i", $id);

                if ($stmt->execute() === false) {
                    die('Execute failed: ' . htmlspecialchars($stmt->error));
                }
                $stmt->close();
            }
        } elseif (is_array($adminRow) && !empty($adminRow)) {
            $_SESSION['AdminId'] = $adminRow['AdminID'];
            if (isset($_SESSION['AdminId'])) {
                header("Location: admin/adminHome.php");
            }
        } else {
            echo "
            <header>
            <div class='head'>
                <img src='./assets/images/logo.png' width='100px' height='39px'>
                <form action='#'>
                    <select class='language'>
                        <option value='English'>English</option>
                        <option value='Hindi'>Hindi</option>
                    </select>
                </form>
            </div>
        </header>

        <div class='center'>
            <div class='container'>
                <div class='about'>
                    <h1 id='aboutH1'>DMRC</h1>
                    <h2 id='aboutH2'>Alumni Portal</h2>
                    <p>
                        Welcome to the official alumni portal of the Delhi Metro Rail Corporation. This platform is
                        dedicated to
                        reconnecting our past employees, fostering professional networks, and celebrating the
                        accomplishments of
                        our alumni community. Join us in staying connected and contributing to the growth and success of
                        our
                        alumni family.
                    </p>
                </div>
                <div class='login-form'>
                    <div class='login-head'>
                        <h2>Login</h2>
                        <p>Welcome! Please enter the details to login.</p>
                    </div>
                    <div class='message'>
                        <p>Wrong Username or Password</p>
                    </div>
                    <form method='post'>
                        <label for='username'>Username</label>
                        <input type='text' id='username' name='username' required>

                        <label for='password'>Password</label>
                        <input type='password' id='password' name='password' required>
                        <br><br>
                        <div class='pcenter'>
                            <input type='submit' name='submit' value='Login'>
                        </div>
                    </form>
                    <br>
                    <div class='pcenter'>
                        <div class='fpass'>
                            <span>Forgot Password? <a href='./pages/ForgotPass.php'>Reset Password</a></span>
                        </div>
                    </div>
                    <br>
                    <div class='pcenter'>
                        <div class='reg-button'>
                            <a href='./pages/Register.php'>Register As New User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>";

        }
        if (isset($_SESSION['id'])) {
            header("location: ./pages/home.php");
        }
    } else {

        ?>
        <header>
            <div class="head">
                <img src="./assets/images/logo.png" width="100px" height="39px">
                <form action="#">
                    <select class="language">
                        <option value="English">English</option>
                        <option value="Hindi">Hindi</option>
                    </select>
                </form>
            </div>
        </header>

        <div class="center">
            <div class="container">
                <div class="about">
                    <h1 id="aboutH1">DMRC</h1>
                    <h2 id="aboutH2">Alumni Portal</h2>
                    <p>
                        Welcome to the official alumni portal of the Delhi Metro Rail Corporation. This platform is
                        dedicated to
                        reconnecting our past employees, fostering professional networks, and celebrating the
                        accomplishments of
                        our alumni community. Join us in staying connected and contributing to the growth and success of
                        our
                        alumni family.
                    </p>
                </div>
                <div class="login-form">
                    <div class="login-head">
                        <h2>Login</h2>
                        <p>Welcome! Please enter the details to login.</p>
                    </div>

                    <form method="post">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <br><br>
                        <div class="pcenter">
                            <input type="submit" name="submit" value="Login">
                        </div>
                    </form>
                    <br>
                    <div class="pcenter">
                        <div class="fpass">
                            <span>Forgot Password? <a href="./pages/ForgotPass.php">Reset Password</a></span>
                        </div>
                    </div>
                    <br>
                    <div class="pcenter">
                        <div class="reg-button">
                            <a href="./pages/Register.php">Register As New User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ pageLanguage: 'en' }, 'center');
    }
</script>

<script type="text/javascript"
    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</html>