<?php
include 'config.php';
include(root . 'common/header.php');

// Fetch patients for the dropdown
$query = "SELECT * FROM tblpatient";
$result = mysqli_query($connect, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

// Fetch patients with prescriptions
$prescriptions_query = "
    SELECT tblpatient.Name, tblprescription.Medicine, tblprescription.Dosage, tblprescription.PrescriptionDate 
    FROM tblprescription
    JOIN tblpatient ON tblprescription.PatientID = tblpatient.AID
    WHERE tblprescription.Dosage IS NOT NULL
";
$prescriptions_result = mysqli_query($connect, $prescriptions_query);
if (!$prescriptions_result) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescribe Medicine</title>
    <link href="<?= roothtml . 'assets/vendor/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link href="<?= roothtml . 'assets/css/style.css' ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #007bff;
            text-align: center;
        }
        .form-label, .table thead th {
            font-weight: bold;
            color: #495057;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            display: none;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Prescribe Medicine</h2>
    
    <!-- Success Message Alert -->
    <div class="alert alert-success" role="alert" id="successMessage">
        Prescription added successfully!
    </div>
    
    <form id="prescriptionForm" class="p-4 rounded" style="background-color: #e9ecef;">
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
            <label for="medicineName" class="form-label">Medicine Name:</label>
            <input type="text" class="form-control" id="medicineName" name="medicineName" placeholder="Enter medicine name" required>
        </div>
        <div class="mb-3">
            <label for="dosage" class="form-label">Dosage:</label>
            <input type="text" class="form-control" id="dosage" name="dosage" placeholder="Enter dosage information" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Prescribe</button>
    </form>

    <hr class="my-4">

    <h3>Patients with Prescriptions</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-primary">
                <tr>
                    <th>Patient Name</th>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Prescription Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prescription = mysqli_fetch_assoc($prescriptions_result)): ?>
                    <tr>
                        <td><?= $prescription['Name']; ?></td>
                        <td><?= $prescription['Medicine']; ?></td>
                        <td><?= $prescription['Dosage']; ?></td>
                        <td><?= date("d-m-Y", strtotime($prescription['PrescriptionDate'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="<?= roothtml . 'assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#prescriptionForm').on('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting normally
            
            $.ajax({
                url: 'prescribe_medicine.php', // The PHP file that handles the prescription
                type: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function (response) {
                    $('#successMessage').show(); // Show the success message
                    $('#prescriptionForm')[0].reset(); // Reset the form fields
                    setTimeout(() => { $('#successMessage').hide(); }, 3000); // Hide message after 3 seconds
                },
                error: function () {
                    alert("Error: Prescription could not be added."); // Display error message
                }
            });
        });
    });
</script>

</body>
</html>
