<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System Registration Page</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
         body {
    font-family: Arial, sans-serif;
    background-image: url('https://t4.ftcdn.net/jpg/04/83/32/57/360_F_483325706_Yy9uS1qzLVKPeNZvefGfJnhscRDb6VW8.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    /* background-position: center;
    margin: 0;
    padding: 0; */
} 
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 30%;
            margin: 20px auto;
        }

        h1, h2 {
            color: #007bff;
            text-align: center;
            padding: 20px 0;
        }

        form {
            margin-top: 20px;
        }

        .form-control {
            width: 100%;
            margin: 0 auto;
        }

        button[type="submit"] {
            width: 100%;
            margin-top: 20px;
            background-color: #343a40;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #1d2124;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        .success-message {
            text-align: center;
            margin-top: 20px;
            color: #28a745; /* Green color for success */
        }
    </style>
</head>
<body>
    <h1>VOTING SYSTEM</h1>
    <div class="container">
        <h2>Register Here</h2>
        <form action="registration.php" method="post" id="registrationForm">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter your voter id" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter your date of birth" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="stateInput" name="state" placeholder="State" readonly>
            </div>
            <button type="submit">Register</button>
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 'true') {
                echo '<div class="success-message">Registration successful!</div>';
            }
            ?>
        </form>
        <p>Already have an account? Go to the login page <a href="index.php">here</a></p>
    </div>

    <script>
        // Function to get user's location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Callback function to handle the position
        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            fetchState(latitude, longitude);
        }

        // Function to fetch the state based on latitude and longitude
        function fetchState(latitude, longitude) {
            fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`)
                .then(response => response.json())
                .then(data => {
                    const state = data.principalSubdivision;
                    document.getElementById('stateInput').value = state;
                })
                .catch(error => console.error('Error:', error));
        }

        // Get location on page load
        window.onload = function() {
            getLocation();
        };
    </script>
</body>
</html>

<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $state = $_POST["state"];

    // Insert data into the voters_details table
    $sql = "INSERT INTO voters_details (voter_id, dob, location) VALUES ('$username', '$password', '$state')";

    if (mysqli_query($db_connection, $sql)) {
        // Redirect to the registration page with a success message
        header("Location: registration.php?success=true");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db_connection);
    }

    mysqli_close($db_connection);
}
?>
