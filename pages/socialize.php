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
                    <a href="home.php" class="link">Home</a>
                    <a class="link" href="profile.php">My Profile</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>
        <div class="space"></div>
        <div class="SearchContainer">
            <div class="box">
                <h2>Search by Alumni Information</h2>
                <input type="text" placeholder="Name of Alumni">
                <input placeholder="Date of Joining" class="textbox-n" type="text" onfocus="(this.type='date')"
                    onblur="(this.type='text')" id="date" />
                <input placeholder="Date of Retirement" class="textbox-n" type="text" onfocus="(this.type='date')"
                    onblur="(this.type='text')" id="date" />
                <select>
                    <option value="">Select Department</option>
                    <option value="IT">IT</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Civil">Civil</option>
                    <option value="HR">HR</option>
                    <option value="Finance">Finance</option>
                    <option value="Engineering">Engineering</option>
                </select>
                <button>Search</button>
            </div>
        </div>
        <div class="alumni-grid">
            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">tejas</p>
                    <p class="alumni-detail">Batch 2020</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>

            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">daksh</p>
                    <p class="alumni-detail">Batch 2021</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>

            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">mayur vihar</p>
                    <p class="alumni-detail">Batch 2019</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>

            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">xyz</p>
                    <p class="alumni-detail">Batch 2019</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>

            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">yoo</p>
                    <p class="alumni-detail">Batch 2016</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>
            <div class="alumni-box">
                <img src="../assets/userpfp/user.png" alt="Profile Picture" class="profile-pic">
                <div class="alumni-info">
                    <p class="alumni-name">abcd</p>
                    <p class="alumni-detail">Batch 2022</p>
                    <button class="connect-button">Connect</button>
                </div>
            </div>

        </div>
        <script>
            const hamMenu = document.querySelector('.ham-menu');
            const offScreenMenu = document.querySelector('.off-screen-menu');
            hamMenu.addEventListener('click', () => {
                hamMenu.classList.toggle('active');
                offScreenMenu.classList.toggle('active');
            })
        </script>
    </body>

    </html>

<?php } ?>