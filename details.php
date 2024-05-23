<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Include database connection or any necessary files
include_once 'db_connect.php';

// Fetch user details based on user role
$user_id = $_SESSION['user_id'];
$sql_user_details = "SELECT * FROM users WHERE user_id = $user_id";
$user_details = $conn->query($sql_user_details)->fetch_assoc();

// Check if user details are found
if ($user_details) {
    // Get the user role
    $user_role = $user_details['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        button {
            padding: 5px 10px; /* Adjust button padding */
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px; /* Adjust button font size */
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
        form.logout-form {
            position: absolute;
            top: 10px; /* Adjust button position */
            right: 10px; /* Adjust button position */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Welcome, <?php echo ucfirst($user_role); ?>!</h2>

        <!-- Display user details -->
        <h3>Your Details</h3>
        <ul>
            <li>User ID: <?php echo $user_details['user_id']; ?></li>
            <li>Username: <?php echo $user_details['username']; ?></li>
            <!-- Add more user details as needed -->
        </ul>
    </div>

    <!-- Link to log out -->
    <form class="logout-form" action="logout.php" method="post">
        <button type="submit">Log Out</button>
    </form>
</body>
</html>

<?php
} else {
    // Handle case where user details are not found
    echo "User details not found.";
}
?>
