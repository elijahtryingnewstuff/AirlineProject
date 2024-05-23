<?php
// Initialize the booking status variable
$booking_status = "";

// Database connection
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password if you have one
$dbname = "airline"; // Change this to the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $passport_num = $_POST['passport_num'];
    $country = $_POST['country'];
    $phone_number = $_POST['phone_number'];
    $flight_id = $_POST['flight_id'];

    // Insert booking into database
    $booking_date = date('Y-m-d H:i:s'); // Current date and time
    $status = 'active'; // Default status is active
    $sql = "INSERT INTO bookings (flight_id, booking_date, status, name, surname, email, passport_num, country, phone_number) 
            VALUES ('$flight_id', '$booking_date', '$status', '$name', '$surname', '$email', '$passport_num', '$country', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        // Set the booking status message
        $booking_status = "Booking successful";
    } else {
        $booking_status = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <style>


    .wrapper input[type="text"],
    .wrapper input[type="email"] {
        width: 300px; /* Adjusted width */
    }


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
        padding: 20px 300px 50px 100px; 
        }



        .wrapper h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: auto;
            padding: 15px 15px 15px 15px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
            font-weight: 600;
            position: absolute;
            top: calc(100% + -350px);
            right: 90px;
           
        }

        input[type="submit"]:hover {
            background-color: #ddd;
        }

        input[type="submit"]:active {
            background-color: #ccc;
        }
        
    </style>
</head>
<body>
<div class="wrapper">
        <h2>Book a Flight</h2>

        <!-- Booking form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            <label for="surname">Surname:</label>
            <input type="text" name="surname" id="surname" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>
            <label for="passport_num">Passport Number:</label>
            <input type="text" name="passport_num" id="passport_num" required><br>
            <label for="country">Country:</label>
            <input type="text" name="country" id="country" required><br>
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required><br>
            <!-- Include flight_id in the form as a hidden input -->
            <input type="hidden" name="flight_id" value="<?php echo isset($_POST['flight_id']) ? $_POST['flight_id'] : ''; ?>">
            <input type="submit" name="submit" value="Submit">
        </form>

        <!-- Display booking status -->
        <p><?php echo $booking_status; ?></p>
    </div>
</body>
</html>
