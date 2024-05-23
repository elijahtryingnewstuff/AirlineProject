
<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Fetch all flights
$sql_flights = "SELECT * FROM flights";
$result_flights = $conn->query($sql_flights);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
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
            position: relative; /* Needed for absolute positioning of button */
            margin-bottom: 20px;
        }

        .wrapper h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
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
            padding: 10px 15px; /* Adjust button padding */
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px; /* Adjust button font size */
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
        form.view-details-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Welcome, Staff!</h2>
        
        <!-- List of Flights -->
        <h3>List of Flights</h3>
        <table>
            <tr>
                <th>Flight Number</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Arrival Date</th>
                <th>Arrival Time</th>
                <th>Departure City</th>
                <th>Arrival City</th>
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
                    // Add more flight details if needed
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No flights available</td></tr>";
            }
            
            ?>
        </table>
    </div>

    <!-- Link to view details -->
    <form class="view-details-button" action="details.php" method="post">
        <button type="submit">View Your Details</button>
    </form>
</body>
</html>