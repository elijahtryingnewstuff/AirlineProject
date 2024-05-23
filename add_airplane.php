<?php
include_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_airplane'])) {
    // Retrieve data from form
    $sernum = $_POST['sernum'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];

    // Insert data into 'airplane' table
    $sql = "INSERT INTO airplane (sernum, manufacturer, model) VALUES ('$sernum', '$manufacturer', '$model')";
    if ($conn->query($sql) === TRUE) {
        echo "New airplane added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
