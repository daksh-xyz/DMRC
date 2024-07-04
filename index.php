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

        $result = mysqli_query($con, "SELECT * FROM alumni WHERE Username='$username' AND Password='$password' ") or die("Select
    Error");
        $row = mysqli_fetch_assoc($result);

        if (is_array($row) && !empty($row)) {
            $_SESSION['fname'] = $row['First_Name'];
            $_SESSION['lname'] = $row['Last_Name'];
            $_SESSION['id'] = $row['Alumni_id'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['password'] = $row['Password'];
            $_SESSION['contact'] = $row['Mobile'];
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
        if (isset($_SESSION['username'])) {
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

</html>