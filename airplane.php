<?php
session_start();

// Check if the user is logged in and has the role of staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Initialize variables for form submission
$sernum = $manufacturer = $model = '';
$success_message = $error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $sernum = $_POST['sernum'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];

    // Validate form data (you can add more validation as needed)
    if (empty($sernum) || empty($manufacturer) || empty($model)) {
        $error_message = "All fields are required";
    } else {
        // Insert airplane into database
        $sql_insert_airplane = "INSERT INTO airplane (sernum, manufacturer, model) VALUES ('$sernum', '$manufacturer', '$model')";
        
        if ($conn->query($sql_insert_airplane) === TRUE) {
            $success_message = "Airplane added successfully";
            // Clear form fields after successful submission
            $sernum = $manufacturer = $model = '';
        } else {
            $error_message = "Error adding airplane: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Airplane</title>
</head>
<body>
    <h2>Add Airplane</h2>

    <!-- Display success or error message -->
    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Airplane form -->
    <form action="" method="post">
        <label for="sernum">Serial Number:</label>
        <input type="text" name="sernum" id="sernum" value="<?php echo $sernum; ?>" required><br>
        
        <label for="manufacturer">Manufacturer:</label>
        <input type="text" name="manufacturer" id="manufacturer" value="<?php echo $manufacturer; ?>" required><br>
        
        <label for="model">Model:</label>
        <input type="text" name="model" id="model" value="<?php echo $model; ?>" required><br>
        
        <button type="submit">Add Airplane</button>
    </form>

    <form action="staff_dashboard.php">
        <button type="submit">Go Back to Dashboard</button>
    </form>
</body>
</html>
