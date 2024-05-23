<?php
session_start();

// Check if the user is logged in and has the role of passenger
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Fetch all available flights
$sql_flights = "SELECT * FROM flights";
$result_flights = $conn->query($sql_flights);

// Check if there is an error with the query
if (!$result_flights) {
    echo "Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background-image: url('bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Needed for absolute positioning of button */
            color: black; /* Set text color to black */
        }

        .wrapper {
            max-width: 800px;
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(9px);
            border-radius: 12px;
            padding: 30px;
        }

        .wrapper h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .wrapper h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid black; /* Set border color to black */
        }

        th, td {
            padding: 10px;
            text-align: left;
            color: black; /* Set text color to black */
        }

        th {
            background-color: rgba(255, 255, 255, 0.2);
        }

        td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        button:hover {
            background-color: #ddd;
        }

        button:active {
            background-color: #ccc;
        }

        /* Position the button */
        .view-details-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Welcome, Passenger!</h2>

        <!-- Display available flights -->
        <h3>Available Flights</h3>
        <table>
            <tr>
                <th>Flight Number</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Arrival Date</th>
                <th>Arrival Time</th>
                <th>Departure City</th>
                <th>Arrival City</th>
                <th>Actions</th>
                <!-- Add more flight details if needed -->
            </tr>
            <?php
            if ($result_flights->num_rows > 0) {
                while($row_flights = $result_flights->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_flights['flight_number'] . "</td>";
                    echo "<td>" . $row_flights['departure_date'] . "</td>";
                    echo "<td>" . $row_flights['departure_time'] . "</td>";
                    echo "<td>" . $row_flights['arrival_date'] . "</td>";
                    echo "<td>" . $row_flights['arrival_time'] . "</td>";
                    
                    // Fetch departure city name
                    $departure_city_id = $row_flights['departure_city_id'];
                    $sql_departure_city = "SELECT city_name FROM cities WHERE city_id = $departure_city_id";
                    $result_departure_city = $conn->query($sql_departure_city);
                    if ($result_departure_city->num_rows > 0) {
                        $departure_city_name = $result_departure_city->fetch_assoc()['city_name'];
                        echo "<td>" . $departure_city_name . "</td>";
                    } else {
                        echo "<td>Unknown</td>";
                    }
                    
                    // Fetch arrival city name
                    $arrival_city_id = $row_flights['arrival_city_id'];
                    $sql_arrival_city = "SELECT city_name FROM cities WHERE city_id = $arrival_city_id";
                    $result_arrival_city = $conn->query($sql_arrival_city);
                    if ($result_arrival_city->num_rows > 0) {
                        $arrival_city_name = $result_arrival_city->fetch_assoc()['city_name'];
                        echo "<td>" . $arrival_city_name . "</td>";
                    } else {
                        echo "<td>Unknown</td>";
                    }
                    
                    // Add button for booking
                    echo "<td>";
                    echo "<form action='booking.php' method='post'>";
                    echo "<input type='hidden' name='flight_id' value='" . $row_flights['flight_id'] . "'>";
                    echo "<button type='submit' name='book_flight'>Book Flight</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No flights available</td></tr>";
            }
            ?>
        </table>
        <!-- Position the button -->
        <form class="view-details-button" action="details.php" method="post">
            <button type="submit">View Your Details</button>
        </form>
    </div>
</body>
</html>
