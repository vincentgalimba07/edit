<?php 
session_start();
include "../../config/database.php";


if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../index.php");
    exit();
}

$message = "";

if (isset($_POST["save"])) {
    $subject_code = trim($_POST["subject_code"]);
    $subject_name = trim($_POST["subject_name"]);
    $units        = (int)$_POST["units"];

    if (!empty($subject_code) && !empty($subject_name) && $units > 0) {
       
        $stmt = mysqli_prepare($conn, "INSERT INTO subjects (subject_code, subject_name, units) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssi", $subject_code, $subject_name, $units);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?message=Subject added successfully!");
            exit();
        } else {
            $message = "Could not save the record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Please fill in all required fields properly.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subject Form</title>
    <!-- Bootstrap CSS -->
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Main Container -->
    <div class="container py-5" style="max-width: 700px;">

        <!-- Subject Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h2 class="mb-4">Subject Form</h2>

                <!-- Display Error Message if any -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <!-- Subject Code -->
                    <div class="mb-3">
                        <label class="form-label">Subject Code</label>
                        <input class="form-control" name="subject_code" required>
                    </div>

                    <!-- Subject Name -->
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <input class="form-control" name="subject_name" required>
                    </div>

                    <!-- Units -->
                    <div class="mb-3">
                        <label class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" min="1" required>
                    </div>

                    <!-- Form Actions -->
                    <button type="submit" name="save" class="btn btn-primary">
                        Save Subject
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

</body>
</html>