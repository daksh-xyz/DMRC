<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/styles.css">
    <link rel="stylesheet" href="../src/HomeStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Home Page</title>
</head>

<body>
    <?php
    include ("../php/config.php");

    if (!isset($_SESSION['id'])) {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    // Prepared statement for fetching alumni details
    $stmt = $con->prepare("SELECT a.*, ad.* FROM alumni_details ad JOIN alumni a ON a.Alumni_id = ad.Alumni_id WHERE a.Alumni_id= ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    $BID = $row['BatchID'];
    $fname = $row['First_Name'];
    $dept = $row['Department'];
    $jDate = $row['Join_Date'];
    $lDate = $row['Last_date'];
    $UAN = $row['UAN'];
    $PF = $row['PF'];
    $PAN = $row['PAN'];
    $PNum = $row['Pension_Number'];

    if (empty($BID) || empty($dept) || empty($jDate) || empty($lDate) || empty($UAN) || empty($PF) || empty($PAN) || empty($PNum)) {
        echo "<script>alert('Please complete profile first!');window.location.href = 'profile.php';</script>";
        exit();
    } else {
        // Check if connections entry exists
        $stmt = $con->prepare("SELECT * FROM connections WHERE Alumni_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $con->prepare("INSERT INTO connections (Alumni_id, User_id, FriendshipStatus) VALUES (?, ?, 0)");
            $stmt->bind_param("ii", $id, $id);
            $stmt->execute();
        }
        $stmt->close();
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
                                <li><a href="profile.php">My Profile</a></li>
                            </ul>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li><a href="../php/logout.php" id="menu-logout">Logout</a></li>
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
                    <a href="socialize.php" class="link">Socialize</a>
                    <a class="link" href="profile.php">My Profile</a>
                    <a id="logout" class="link" href="../php/logout.php">Logout</a>
                </div>
            </div>
        </header>
        <main class="center">
            <?php
            $stmt = $con->prepare("SELECT * FROM alumni_docs WHERE SenderID=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $verify_query = $stmt->get_result();
            if (!mysqli_num_rows($verify_query)) {
                $f16 = "null";
                $pSlip = "null";
                $SA = "null";
                $service = "null";
                $release = "null";
            } else {
                $stmt = $con->prepare("SELECT * FROM alumni_docs WHERE SenderID=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $getDocs = $result->fetch_assoc();
                $f16 = $getDocs['F16'];
                $pSlip = $getDocs['pSlip'];
                $SA = $getDocs['SAnnuation'];
                $service = $getDocs['ServiceCertificate'];
                $release = $getDocs['ReleaseLetter'];
            }
            echo '
            <div class="row" id="data">
                <div class="col">
                    <a href="#" onclick="run(\'' . $f16 . '\', ' . $id . ', \'f16\')"><img src="../assets/images/pdf.png" height="50px"></a>
                    <p>Form 16</p>
                </div>
                <div class="col">
                    <a href="#" onclick="run(\'' . $pSlip . '\', ' . $id . ', \'pSlip\')"><img src="../assets/images/policy.png" height="50px"></a>
                    <p>Pay Slip</p>
                </div>
                <div class="col">
                    <a href="#" onclick="run(\'' . $SA . '\', ' . $id . ', \'SA\')"><img src="../assets/images/pdf.png" height="50px"></a>
                    <p>Superannuation Statement</p>
                </div>
                <div class="col">
                    <a href="#" onclick="run(\'' . $service . '\', ' . $id . ', \'service\')"><img src="../assets/images/pdf.png" height="50px"></a>
                    <p>Service Certificate</p>
                </div>
                <div class="col">
                    <a href="#" onclick="run(\'' . $release . '\', ' . $id . ', \'release\')"><img src="../assets/images/pdf.png" height="50px"></a>
                    <p>Release Letter</p>
                </div>
            </div>';
            ?>
        </main>
        <script>
            function checkFileExist(urlToFile) {
                var xhr = new XMLHttpRequest();
                xhr.open('HEAD', urlToFile, false);
                xhr.send();

                return xhr.status !== 404;
            }

            function run(urlToFile, alumniId, docName) {
                var fileUrl = "http://localhost/DMRC/uploads/" + urlToFile;
                var result = checkFileExist(fileUrl);

                if (result) {
                    window.location.href = fileUrl;
                } else {
                    if (confirm('File does not exist! Do you want to request the admin for the document?')) {
                        sendDocumentRequest(alumniId, docName);
                    }
                }
            }

            function sendDocumentRequest(alumniId, docName) {
                $.ajax({
                    type: 'POST',
                    url: '../php/requestDocument.php',
                    data: {
                        alumni_id: alumniId,
                        doc_name: docName
                    },
                    success: function (response) {
                        alert(response);
                        $("#data").load(" #data > *");
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            const hamMenu = document.querySelector('.ham-menu');
            const offScreenMenu = document.querySelector('.off-screen-menu');
            hamMenu.addEventListener('click', () => {
                hamMenu.classList.toggle('active');
                offScreenMenu.classList.toggle('active');
            });
        </script>
    <?php } ?>
</body>

</html>