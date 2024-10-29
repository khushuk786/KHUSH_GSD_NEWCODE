<?php
include 'config.php'; // Include your database configuration file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $patientID = $_POST['patient_id'];
    $medicineName = $_POST['medicineName'];
    $dosage = $_POST['dosage'];

    // Prepare the SQL query
    $query = "INSERT INTO tblprescription (PatientID, Medicine, Dosage, PrescriptionDate) VALUES (?, ?, ?, NOW())";

    // Prepare statement
    if ($stmt = mysqli_prepare($connect, $query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'iss', $patientID, $medicineName, $dosage);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Prescription added successfully!";
        } else {
            echo "Error: " . mysqli_error($connect); // Output any error from the execution
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connect); // Output error in preparing the statement
    }
}

// Close the database connection
mysqli_close($connect);
?>
