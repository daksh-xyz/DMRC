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

        <title>Socialise with Alumni</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .header {
                background-color: red;
                color: white;
                text-align: center;
                padding: 10px 0;
            }

            .container {
                display: flex;
                justify-content: space-around;
                margin: 20px;
            }

            .box {
                border: 1px solid #ccc;
                padding: 20px;
                border-radius: 5px;
                width: 45%;
            }

            .box h2 {
                text-align: center;
            }

            .box input,
            .box select {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .box button {
                width: 100%;
                padding: 10px;
                background-color: red;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .box button:hover {
                background-color: darkred;
            }
        </style>
        </head>

        <div class="container">
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
            <div class="box">
                <h2>Search by Employee ID</h2>
                <input type="text" placeholder="Employee ID" />
                <button>Search</button>
            </div>
        </div>

        <div style="margin-left:30px;">
            <div class="box">
                <h2>Search by Year of Retirement</h2>
                <input type="text" placeholder="Retirement year" />

                <button>Search</button>
            </div>
        </div>
    </body>

    </html>

    <script src="scripts.js"></script>
<?php } ?>
</body>

</html>