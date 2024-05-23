<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add City</title>
    <style>
        /* CSS styling for the form */
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h2>Add City</h2>
    <form action="add_city.php" method="post">
        <label for="city_name">City Name:</label>
        <input type="text" id="city_name" name="city_name" required><br><br>
        
        <label for="country_id">Country ID:</label>
        <input type="text" id="country_id" name="country_id" required><br><br>
        
        <label for="country_name">Country Name:</label>
        <input type="text" id="country_name" name="country_name" required><br><br>
        
        <input type="submit" name="add_city" value="Add City">
    </form>
</body>
</html>
