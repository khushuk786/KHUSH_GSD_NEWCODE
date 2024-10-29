<?php
session_start();
include 'config.php';
include(root . 'common/header.php');

// Fetch patients from the database
$query = "SELECT * FROM tblpatient";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

// Fetch files from the database
$file_query = "SELECT tblfiles.*, tblpatient.Name AS PatientName 
               FROM tblfiles 
               JOIN tblpatient ON tblfiles.PatientID = tblpatient.AID";
$file_result = mysqli_query($connect, $file_query);

if (!$file_result) {
    die("File query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link href="<?= roothtml . 'assets/vendor/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?= roothtml . 'assets/css/style.css' ?>" rel="stylesheet">
    <style>
        body { background-color: #f9fafb; }
        .container { max-width: 850px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; }
        h2 { color: #007bff; text-align: center; }
        .form-container { background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .btn-primary { background-color: #007bff; border-color: #007bff; transition: 0.3s; }
        .table-container { margin-top: 30px; }
        .table thead th { background-color: #007bff; color: white; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Upload Files</h2>
    
    <div class="form-container">
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="patientID" class="form-label">Select Patient:</label>
                <select class="form-select" id="patientID" name="patient_id" required>
                    <option value="" disabled selected>Select a patient</option>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $row['AID']; ?>"><?= $row['Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fileUpload" class="form-label">Select File (X-ray/Lab Result):</label>
                <input type="file" class="form-control" id="fileUpload" name="fileToUpload" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>

    <h2 class="mt-5">Uploaded Files</h2>
    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>File</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($file_row = mysqli_fetch_assoc($file_result)): ?>
                    <tr>
                        <td><?= $file_row['PatientName']; ?></td>
                        <td><a href="<?= $file_row['FilePath']; ?>" target="_blank">View File</a></td>
                        <td><?= date("d-m-Y", strtotime($file_row['UploadDate'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</div>

<script src="<?= roothtml . 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
</body>
</html>
