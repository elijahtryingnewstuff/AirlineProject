<?php
session_start();

// Check if the user is logged in and has the role of passenger
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Check if the user has clicked the "Cancel Booking" button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    
    // Update the booking status to "cancelled" in the database
    $sql_cancel_booking = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = $booking_id";
    
    if ($conn->query($sql_cancel_booking) === TRUE) {
        $cancel_message = "Booking successfully cancelled";
    } else {
        $cancel_error = "Error cancelling booking: " . $conn->error;
    }
}

// Fetch the user's bookings
$user_id = $_SESSION['user_id'];
$sql_bookings = "SELECT * FROM bookings WHERE user_id = $user_id";
$result_bookings = $conn->query($sql_bookings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
</head>
<body>
    <h2>Your Bookings</h2>

    <?php
    // Display cancellation message or error, if any
    if (isset($cancel_message)) {
        echo "<p>$cancel_message</p>";
    } elseif (isset($cancel_error)) {
        echo "<p>$cancel_error</p>";
    }
    ?>

    <table>
        <tr>
            <th>Booking ID</th>
            <th>Flight Number</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result_bookings->num_rows > 0) {
            while($row = $result_bookings->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['booking_id'] . "</td>";
                echo "<td>" . $row['flight_id'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>";
                // Add cancel booking form
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='booking_id' value='" . $row['booking_id'] . "'>";
                echo "<button type='submit' name='cancel_booking'>Cancel Booking</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No bookings found</td></tr>";
        }
        ?>
    </table>

    <form action="passenger_dashboard.php">
        <button type="submit">Go Back</button>
    </form>
</body>
</html>
