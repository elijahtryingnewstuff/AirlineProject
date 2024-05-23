<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include_once 'db_connect.php';

// Fetch admin details
$user_id = $_SESSION['user_id'];
$sql_admin_details = "SELECT * FROM users WHERE user_id = $user_id";
$result_admin_details = $conn->query($sql_admin_details);
$admin_details = $result_admin_details->fetch_assoc();

// Fetch all staff members
$sql_staff = "SELECT * FROM users WHERE role = 'staff'";
$result_staff = $conn->query($sql_staff);

// Fetch all flights
$sql_flights = "SELECT * FROM flights";
$result_flights = $conn->query($sql_flights);

// Fetch all cities
$sql_cities = "SELECT * FROM cities";
$result_cities = $conn->query($sql_cities);

// Fetch all countries
$sql_countries = "SELECT * FROM countries";
$result_countries = $conn->query($sql_countries);

// Fetch all airplanes
$sql_airplanes = "SELECT * FROM airplane";
$result_airplanes = $conn->query($sql_airplanes);

// Fetch all bookings
$sql_bookings = "SELECT * FROM bookings";
$result_bookings = $conn->query($sql_bookings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* CSS styling for the admin dashboard */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif; /* Set a fallback font */
        }

        .background {
            background-image: url('bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0; /* Ensure the background covers the entire viewport from the top */
            left: 0; /* Ensure the background covers the entire viewport from the left */
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .wrapper {
            max-width: 800px;
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(9px);
            border-radius: 12px;
            padding: 30px;
            position: relative;
            margin: 50px auto; /* Center the wrapper horizontally */
            z-index: 1; /* Ensure wrapper stays above background */
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

        form {
            margin-bottom: 20px; /* Add margin between forms */
        }

        form label {
            display: block; /* Make labels block-level for better spacing */
            margin-bottom: 5px; /* Add spacing between label and input */
        }

        form input[type="text"],
        form select {
            padding: 8px; /* Adjust input padding */
            width: 100%; /* Make inputs full-width */
            margin-bottom: 10px; /* Add spacing between inputs */
        }

        form input[type="submit"],
        form button {
            padding: 10px 15px; /* Adjust button padding */
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px; /* Adjust button font size */
            color: #333;
            font-weight: 600;
        }

        form input[type="submit"]:hover,
        form button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="wrapper">
        
        <h2>Welcome, <?php echo $admin_details['username']; ?>!</h2>
        <h3>Your Details</h3>
        <ul>
            <li>User ID: <?php echo $admin_details['user_id']; ?></li>
            <li>Username: <?php echo $admin_details['username']; ?></li>
            <li>Email: <?php echo $admin_details['email']; ?></li>
            <!-- Add more admin details if needed -->
        </ul>
        <!-- View Details Button -->
<form action="details.php" method="get">
    <button type="submit">View Details</button>
</form>

        
        <!-- Display Staff Members -->
        <h3>List of Staff Members</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <!-- Add more staff details if needed -->
            </tr>
            <?php
            if ($result_staff->num_rows > 0) {
                while($row_staff = $result_staff->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_staff['user_id'] . "</td>";
                    echo "<td>" . $row_staff['username'] . "</td>";
                    echo "<td>" . $row_staff['email'] . "</td>";
                    // Add more staff details if needed
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No staff members found</td></tr>";
            }
            ?>
        </table>

   
<h3>Add Flight</h3>
<form action="add_flight.php" method="post">
    <label for="flight_number">Flight Number:</label>
    <input type="text" id="flight_number" name="flight_number" required><br><br>
    
    <label for="departure_date">Departure Date:</label>
    <input type="date" id="departure_date" name="departure_date" required><br><br>
    
    <label for="departure_time">Departure Time:</label>
    <input type="time" id="departure_time" name="departure_time" required><br><br>
    
    <label for="arrival_date">Arrival Date:</label>
    <input type="date" id="arrival_date" name="arrival_date" required><br><br>
    
    <label for="arrival_time">Arrival Time:</label>
    <input type="time" id="arrival_time" name="arrival_time" required><br><br>
    
    <label for="departure_city">Departure City:</label>
    <select id="departure_city" name="departure_city" required>
        <!-- Populate options dynamically from database -->
        <?php
        while($row_cities = $result_cities->fetch_assoc()) {
            echo "<option value='" . $row_cities['city_id'] . "'>" . $row_cities['city_name'] . "</option>";

            
        }
        ?>
    </select><br><br>
    
    <label for="arrival_city">Arrival City:</label>
    <select id="arrival_city" name="arrival_city" required>
        <!-- Populate options dynamically from database -->
        <?php
        $result_cities->data_seek(0); // Reset result pointer
        while($row_cities = $result_cities->fetch_assoc()) {
            echo "<option value='" . $row_cities['city_id'] . "'>" . $row_cities['city_name'] . "</option>";
        }
        ?>
    </select><br><br>
    
    <label for="airplane">Airplane:</label>
    <select id="airplane" name="airplane" required>
        <!-- Populate options dynamically from database -->
        <?php
        while($row_airplanes = $result_airplanes->fetch_assoc()) {
            echo "<option value='" . $row_airplanes['airplane_id'] . "'>" . $row_airplanes['model'] . "</option>";
        }
        ?>
    </select><br><br>
    
    <input type="submit" name="add_flight" value="Add Flight">
</form>

<!-- Add Airplane Form -->
<h3>Add Airplane</h3>
<form action="add_airplane.php" method="post">
    <label for="sernum">Serial Number:</label>
    <input type="text" id="sernum" name="sernum" required><br><br>
    
    <label for="manufacturer">Manufacturer:</label>
    <input type="text" id="manufacturer" name="manufacturer" required><br><br>
    
    <label for="model">Model:</label>
    <input type="text" id="model" name="model" required><br><br>
    
    <input type="submit" name="add_airplane" value="Add Airplane">
</form>


        <!-- Edit Flight Button -->
        <form action="edit_flight_form.php" method="get">
            <button type="submit">Edit Flight</button>
        </form>

        <!-- List of Cities -->
        <!-- List of Cities -->
<h3>List of Cities</h3>
<table>
    <tr>
        <th>City ID</th>
        <th>City Name</th>
        <th>Country ID</th>
        <th>Country Name</th>
    </tr>
    <?php
    if ($result_cities->num_rows > 0) {
        while($row_cities = $result_cities->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_cities['city_id'] . "</td>";
            echo "<td>" . $row_cities['city_name'] . "</td>";
            echo "<td>" . $row_cities['country_id'] . "</td>";
            echo "<td>" . $row_cities['country_name'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No cities available</td></tr>";
    }
    ?>
</table>

<!-- Add City Button -->
<form action="add_city_form.php" method="get">
    <button type="submit">Add City</button>
</form>


        <!-- List of Countries -->
        <!-- List of Countries -->
<h3>List of Countries</h3>
<table>
    <tr>
        <th>Country ID</th>
        <th>Country Name</th>
    </tr>
    <?php
    if ($result_countries->num_rows > 0) {
        while($row_countries = $result_countries->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_countries['country_id'] . "</td>";
            echo "<td>" . $row_countries['country_name'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No countries available</td></tr>";
    }
    ?>
</table>

<!-- Add Country Form -->
<form action="add_country_form.php" method="get">
    <button type="submit">Add Country</button>
</form>


        <!-- List of Airplanes -->
        <h3>List of Airplanes</h3>
        <table>
            <tr>
                <th>Serial Number</th>
                <th>Manufacturer</th>
                <th>Model</th>
            </tr>
            <?php
            if ($result_airplanes->num_rows > 0) {
                 while($row_airplanes = $result_airplanes->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_airplanes['sernum'] . "</td>";
                        echo "<td>" . $row_airplanes['manufacturer'] . "</td>";
                        echo "<td>" . $row_airplanes['model'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No airplanes available</td></tr>";
                }
            ?>
        </table>

        <!-- List of Bookings -->
        <h3>List of Bookings</h3>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>User ID</th>
                <th>Flight ID</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Passport Number</th>
                <th>Country</th>
                <th>Phone Number</th>
            </tr>
            <?php
            if ($result_bookings->num_rows > 0) {
                while($row_bookings = $result_bookings->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_bookings['booking_id'] . "</td>";
                    echo "<td>" . $row_bookings['user_id'] . "</td>";
                    echo "<td>" . $row_bookings['flight_id'] . "</td>";
                    echo "<td>" . $row_bookings['booking_date'] . "</td>";
                    echo "<td>" . $row_bookings['status'] . "</td>";
                    echo "<td>" . $row_bookings['name'] . "</td>";
                    echo "<td>" . $row_bookings['surname'] . "</td>";
                    echo "<td>" . $row_bookings['email'] . "</td>";
                    echo "<td>" . $row_bookings['passport_num'] . "</td>";
                    echo "<td>" . $row_bookings['country'] . "</td>";
                    echo "<td>" . $row_bookings['phone_number'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No bookings available</td></tr>";
            }
            ?>
        </table>
        
    </div>
</body>
</html>
