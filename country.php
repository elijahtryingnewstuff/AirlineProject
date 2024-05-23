<?php
session_start();

// Check if the user is logged in and has the role of staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Initialize variables for form submission
$country_id = $country_name = '';
$success_message = $error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $country_id = $_POST['country_id'];
    $country_name = $_POST['country_name'];

    // Validate form data (you can add more validation as needed)
    if (empty($country_id) || empty($country_name)) {
        $error_message = "All fields are required";
    } else {
        // Insert country into database
        $sql_insert_country = "INSERT INTO countries (country_id, country_name) VALUES ('$country_id', '$country_name')";
        
        if ($conn->query($sql_insert_country) === TRUE) {
            $success_message = "Country added successfully";
            // Redirect to cities.php
            header("Location: cities.php");
            exit();
        } else {
            $error_message = "Error adding country: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Country</title>
</head>
<body>
    <h2>Add Country</h2>

    <!-- Display success or error message -->
    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Country form -->
    <form action="" method="post">
        <label for="country_id">Country ID:</label>
        <input type="text" name="country_id" id="country_id" value="<?php echo $country_id; ?>" required><br>
        
        <label for="country_name">Country Name:</label>
        <input type="text" name="country_name" id="country_name" value="<?php echo $country_name; ?>" required><br>
        
        <button type="submit">Add Country</button>
    </form>

    <form action="cities.php">
        <button type="submit">Go Back to Cities</button>
    </form>
</body>
</html>
