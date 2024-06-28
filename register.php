<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    < class="signup-container">
        <form class="signup-form">

        <?php 
        
        include("php/config.php");
        if (isset(  $_POST["submit"])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = $_POST['password'];

        $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email' ");    
        if (mysqli_num_rows($verify_query) != 0) {
            echo"<div class= 'message'>
            <p> This email is used , Try another One Please! </p>
            </div> <br>";
            echo "<a href = 'javascript: self.history.back() '><button class = 'btn'> Go Back </button>";
        
        }
          else{
            mysqli+query ($con,"INSERT INTO users (Username, Email, Age , Password) VALUES ('$username',$email',$age',$password' )") or die("Error Occured") ;
            echo"<div class= 'message'>
            <p> Registration Successfull! </p>
            </div> <br>";
            echo "<a href = 'index.php'><button class = 'btn'> Login Now </button>";
          }
          
          else{
        
        ?>



            <h2>Sign Up</h2>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="age">Age</label>
            <input type="number" id="age" name="age" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>
            <p>Already a member? <a href="./pages/Signin.php">Sign In</a></p>
        </form>
        <?php } ?>
    </div>
</body>
</html>
