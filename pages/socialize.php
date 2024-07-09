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
        ?>
        <header>

            <div class="head">
                <img src="../assets/images/logo.png" width="100px" height="39px">
                <div>
                    <a href="home.php" class="link">Home</a>
                    <a class="link" href="profile.php">My Profile</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>

        <div class="SearchContainer">
            <div class="box">
                <h2>Search by Alumni Information</h2>
                <input type="text" placeholder="Name of Alumni" />
                <input type="date" placeholder="Date of Joining" />
                <input type="date" placeholder="Date of Retirement" />
                <select>
                    <option value="">Select Department</option>
                    <option value="IT">IT</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Civil">Civil</option>
                    <option value="HR">HR</option>
                    <option value="Finance">Finance</option>

                </select>
                <button>Search</button>
            </div>
        </div>
        <div class="ResultContainer">

        </div>
    </body>

    </html>

    <script src="scripts.js"></script>
<?php } ?>
</body>

</html>