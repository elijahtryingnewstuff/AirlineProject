<?php
// Include database connection
include_once 'db_connect.php';

// Fetch flights data
$sql_flights = "SELECT * FROM flights";
$result_flights = $conn->query($sql_flights);

// Check if flights are found
if ($result_flights->num_rows > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flight</title>
</head>
<body>
    <h3>Edit Flight</h3>
    <form action="" method="post">
        <label for="flight_id">Select Flight:</label>
        <select name="flight_id" id="flight_id">
            <?php
            // Loop through each flight and populate the dropdown
            while ($row_flights = $result_flights->fetch_assoc()) {
                echo "<option value='" . $row_flights['flight_id'] . "'>" . $row_flights['flight_number'] . "</option>";
            }
            ?>
        </select><br><br>
        <!-- Add input fields for editing flight data here -->
        <!-- For example: -->
        <label for="new_flight_number">New Flight Number:</label>
        <input type="text" id="new_flight_number" name="new_flight_number" required><br><br>
        
        <label for="new_departure_date">New Departure Date:</label>
        <input type="date" id="new_departure_date" name="new_departure_date" required><br><br>
        
        <!-- Add more input fields for other flight data -->
        
        <input type="submit" name="edit_flight" value="Edit Flight">
    </form>

    <!-- Button to go back to admin dashboard -->
    <form action="admin_dashboard.php" method="get">
        <button type="submit">Back to Admin Dashboard</button>
    </form>
</body>
</html>

<?php
} else {
    // Handle case where no flights are found
    echo "No flights found.";
}
?>
