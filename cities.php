<?php
session_start();

// Check if the user is logged in and has the role of staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Initialize variables for form submission
$city_id = $city_name = $country_id = $country_name = '';
$success_message = $error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $city_id = $_POST['city_id'];
    $city_name = $_POST['city_name'];
    $country_id = $_POST['country_id'];
    $country_name = $_POST['country_name'];

    // Validate form data (you can add more validation as needed)
    if (empty($city_id) || empty($city_name) || empty($country_id) || empty($country_name)) {
        $error_message = "All fields are required";
    } else {
        // Insert city into database
        $sql_insert_city = "INSERT INTO cities (city_id, city_name, country_id, country_name) VALUES ('$city_id', '$city_name', '$country_id', '$country_name')";
        
        if ($conn->query($sql_insert_city) === TRUE) {
            $success_message = "City added successfully";
            // Clear form fields after successful submission
            $city_id = $city_name = $country_id = $country_name = '';
        } else {
            $error_message = "Error adding city: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add City</title>
</head>
<body>
    <h2>Add City</h2>

    <!-- Display success or error message -->
    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- City form -->
    <form action="" method="post">
        <label for="city_id">City ID:</label>
        <input type="text" name="city_id" id="city_id" value="<?php echo $city_id; ?>" required><br>
        
        <label for="city_name">City Name:</label>
        <input type="text" name="city_name" id="city_name" value="<?php echo $city_name; ?>" required><br>
        
        <label for="country_id">Country ID:</label>
        <input type="text" name="country_id" id="country_id" value="<?php echo $country_id; ?>" required><br>
        
        <label for="country_name">Country Name:</label>
        <input type="text" name="country_name" id="country_name" value="<?php echo $country_name; ?>" required><br>
        
        <button type="submit">Add City</button>
    </form>

    <!-- Button to add country -->
    <form action="country.php">
        <button type="submit">Add Country</button>
    </form>

    <form action="staff_dashboard.php">
        <button type="submit">Go Back to Dashboard</button>
    </form>
</body>
</html>
