<?php
session_start();
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the uploads directory exists, if not, create it
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientID = $_POST['patient_id'];
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check for upload errors
    if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "File upload error: " . $_FILES["fileToUpload"]["error"];
        header("Location: uploads.php");
        exit();
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $_SESSION['message'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($fileType, ["jpg", "jpeg", "png", "pdf"])) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
        $uploadOk = 0;
    }

    // Try to upload file
    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // Insert into database
            $insert_query = "INSERT INTO tblfiles (PatientID, FilePath, UploadDate) VALUES ('$patientID', '$targetFile', NOW())";
            if (mysqli_query($connect, $insert_query)) {
                $_SESSION['message'] = "File uploaded successfully!";
            } else {
                $_SESSION['message'] = "Database error: " . mysqli_error($connect);
            }
        } else {
            $_SESSION['message'] = "File upload failed. Please try again.";
        }
    }

    // Redirect back to the upload page
    header("Location: uploads.php");
    exit();
}
