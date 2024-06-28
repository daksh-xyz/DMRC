<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../src/styles.css">
    <link rel="stylesheet" href="../src/RegisterStyle.css">
</head>

<body>
    <?php

    include ("../php/config.php");
    if (isset($_POST["submit"])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $password = $_POST['password'];

        $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email' ");
        if (mysqli_num_rows($verify_query) != 0) {
            echo "<div class= 'message'>
        <p> This email is used , Try another One Please! </p>
        </div> <br>";
            echo "<a href = 'javascript: self.history.back() '><button class = 'btn'> Go Back </button>";

        } else {
            mysqli_query($con, "INSERT INTO users (Username, Email, Age , Password) VALUES ('$username',$email',$age',$password' )") or die("Error Occured");
            echo "<div class= 'message'>
        <p> Registration Successfull! </p>
        </div> <br>";
            echo "<a href = '../index.php'><button class = 'btn'> Login Now </button>";
        }
    } else {

        ?>
        <header>
            <div class="head">
                <img src="../assets/images/logo.png" width="100px" height="39px">
                <form action="#">
                    <select class="language">
                        <option value="English">English</option>
                        <option value="Hindi">Hindi</option>
                    </select>
                </form>
            </div>
        </header>
        <div class="pcenter">
            <div class="login-form">
                <div class="login-head">
                    <h2>Sign Up</h2>
                    <p>Please enter the details to sign up.</p>
                </div>

                <form method="post">

                    <div class="col">
                        <div class="row">
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname" required>
                        </div>
                        <div class="row">
                            <label for="lname">Last Name</label>
                            <input type="text" id="lname" name="lname">
                        </div>
                    </div>

                    <label for="mobile">Phone Number</label>
                    <input type="text" id="mobile" name="mobile" required>

                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" required>

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>

                    <div class="col">
                        <div class="row">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="row">
                            <label for="district">District</label>
                            <input type="text" id="dist" name="district" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        <div class="row">
                            <label for="pincode">Pincode</label>
                            <input type="number" id="pcode" name="pincode" required>
                        </div>
                    </div>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <div class="pcenter">
                        <input type="submit" name="submit" value="Sign up">
                    </div>
                </form>
                <div class="pcenter">
                    <div class="fpass">
                        <span>Already have an account? <a href="../index.php">Login Here</a></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</body>

</html>