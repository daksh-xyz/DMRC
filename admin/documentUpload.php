<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/ProfileStyles.css">
    <link rel="stylesheet" href="../src/friendView.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Upload</title>
</head>

<body>
    <?php
    if (isset($_GET['SenderID'])) {
        $SenderID = $_GET['SenderID'];
    } else {
        echo "<script>
            var someIframe = window.parent.document.getElementById('friendView1');
            var iframe_container = window.parent.document.getElementById('iframe-container1');
            iframe_container.style.display = 'None';
            someIframe.style.display = 'None';
            </script>";
        exit;
    }

    include ("../php/config.php");


    if (isset($_POST["docUpload"])) {
        $fileFields = ['F16', 'pSlip', 'SAnnuation', 'ServiceCertificate', 'ReleaseLetter'];
        $statusFields = ['F16Status', 'pSlipStatus', 'SAnnuationStatus', 'ServiceCertificateStatus', 'ReleaseLetterStatus'];
        $verifiedStatusFields = [];
        $validFileExtension = ['pdf', 'docx'];
        $maxFileSize = 15000000; // 15MB
    
        foreach ($fileFields as $index => $field) {
            if ($_FILES[$field]["error"] == 4) {
                echo "<script> alert('Document for $field does not exist'); </script>";
            } else {
                $fileName = $_FILES[$field]["name"];
                $fileSize = $_FILES[$field]["size"];
                $tmpName = $_FILES[$field]["tmp_name"];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExtension, $validFileExtension)) {
                    echo "<script> alert('Invalid document extension for $field'); </script>";
                } elseif ($fileSize > $maxFileSize) {
                    echo "<script> alert('Document size for $field is too large'); </script>";
                } else {
                    $uniqueFileName = uniqid() . '.' . $fileExtension;
                    move_uploaded_file($tmpName, '../uploads/' . $uniqueFileName);
                    array_push($verifiedStatusFields, $statusFields[$index]);

                    $query = "UPDATE alumni_docs SET $field='$uniqueFileName' WHERE SenderID='$SenderID'";
                    if (mysqli_query($con, $query)) {
                        echo "<script> alert('Document $field uploaded successfully!'); </script>";
                    } else {
                        echo "<script> alert('Database update failed for $field'); </script>";
                    }
                }
            }
        }

        foreach ($verifiedStatusFields as $statusField) {
            $query = "UPDATE alumni_docs SET $statusField='Completed' WHERE SenderID='$SenderID'";
            if (!mysqli_query($con, $query)) {
                echo "<script> alert('Failed to update status for $statusField'); </script>";
            }
        }

        echo "<script> window.location.href = 'documentUpload.php?SenderID=$SenderID';</script>";
        exit;
    }

    ?>

    <div class="my-form">
        <?php
        $stmt = $con->prepare("SELECT * FROM alumni_docs WHERE SenderID=?");
        $stmt->bind_param('i', $SenderID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $getDocData = $result->fetch_assoc();
            $f16 = $getDocData['F16'];
            $pSlip = $getDocData['pSlip'];
            $SA = $getDocData['SAnnuation'];
            $sCertificate = $getDocData['ServiceCertificate'];
            $release = $getDocData['ReleaseLetter'];
        } else {
            echo "
            <script>
                $.ajax({
                    type: 'POST',
                    url: '../php/requestDocument.php',
                    data: {
                        alumni_id: $SenderID
                    },
                    success: function (response) {
                        $('#notif').load(' #notif > *');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            </script>            
            ";
            exit;
        }
        ?>
        <form id="notif" method="post" enctype="multipart/form-data">
            <div class="ucenter upload-form">
                <div class="form-group" style="color:black;">
                    <label for="f16">F16: <a href="#"
                            onclick="run('<?php echo $f16 ?>', '<?php echo $SenderID ?>', 'F16')"><?php echo $f16 ?></a></label>
                    <div class="u">
                        <input type="file" name="F16" />
                        <a href="#" onclick="deleteDocument('<?php echo $SenderID ?>', 'F16')"><img
                                src="../assets/images/delete.png" alt="X" width="25px" id="delete"></a>
                    </div>
                </div>
                <div class="form-group" style="color:black;">
                    <label for="pSlip">Pay Slip: <a href="#"
                            onclick="run('<?php echo $pSlip ?>', '<?php echo $SenderID ?>', 'pSlip')"><?php echo $pSlip ?></a></label>
                    <div class="u">
                        <input type="file" name="pSlip" />
                        <a href="#" onclick="deleteDocument('<?php echo $SenderID ?>', 'pSlip')"><img
                                src="../assets/images/delete.png" alt="X" width="25px" id="delete"></a>
                    </div>
                </div>
                <div class="form-group" style="color:black;">
                    <label for="SA">Super Annuation: <a href="#"
                            onclick="run('<?php echo $SA ?>', '<?php echo $SenderID ?>', 'SAnnuation')"><?php echo $SA ?></a></label>
                    <div class="u">
                        <input type="file" name="SAnnuation" />
                        <a href="#" onclick="deleteDocument('<?php echo $SenderID ?>', 'SAnnuation')"><img
                                src="../assets/images/delete.png" alt="X" width="25px" id="delete"></a>
                    </div>
                </div>
                <div class="form-group" style="color:black;">
                    <label for="servCertificate">Service Certificate: <a href="#"
                            onclick="run('<?php echo $sCertificate ?>', '<?php echo $SenderID ?>', 'ServiceCertificate')"><?php echo $sCertificate ?></a></label>
                    <div class="u">
                        <input type="file" name="ServiceCertificate" />
                        <a href="#" onclick="deleteDocument('<?php echo $SenderID ?>', 'ServiceCertificate')"><img
                                src="../assets/images/delete.png" alt="X" width="25px" id="delete"></a>
                    </div>
                </div>
                <div class="form-group" style="color:black;">
                    <label for="releaseLetter">Release Letter: <a href="#"
                            onclick="run('<?php echo $release ?>', '<?php echo $SenderID ?>', 'ReleaseLetter')"><?php echo $release ?></a></label>
                    <div class="u">
                        <input type="file" name="ReleaseLetter" />
                        <a href="#" onclick="deleteDocument('<?php echo $SenderID ?>', 'ReleaseLetter')"><img
                                src="../assets/images/delete.png" alt="X" width="25px" id="delete"></a>
                    </div>
                </div>
            </div>
            <input type="submit" name="docUpload" value="Upload Files" class="docUpload">
        </form>
        <div>
            <input class="continue-btn" onclick="closeWin()" value="CLOSE" readonly>
        </div>
    </div>

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
                alert("No document uploaded yet!");
            }
        }

        function deleteDocument(alumniId, docName) {
            $.ajax({
                type: 'POST',
                url: '../php/deleteDocument.php',
                data: {
                    alumni_id: alumniId,
                    doc_id: docName
                },
                success: function (response) {
                    $("#notif").load(" #notif > *");
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function closeWin() {
            var someIframe1 = window.parent.document.getElementById('friendView1');
            var someIframe = window.parent.document.getElementById('friendView');
            var iframe_container1 = window.parent.document.getElementById('iframe-container1');
            var iframe_container = window.parent.document.getElementById('iframe-container');
            iframe_container1.style.display = "None";
            iframe_container.style.display = "None";
            someIframe1.style.display = "None";
            someIframe.style.display = "None";
        }
    </script>
</body>

</html>