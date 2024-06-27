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
                    our alumni community. Join us in staying connected and contributing to the growth and success of our
                    alumni family.
                </p>

            </div>
            <div class="login-form">
                <div class="login-head">
                    <h2>Login</h2>
                    <p>Welcome! Please enter the details to login.</p>
                </div>

                <form action="#">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <br><br>
                    <div class="pcenter">
                        <input type="submit" value="Login">
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
                        <a href="./pages/Register.php" target=" _parent">Register As New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>