<?php
include("database.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $voterid = $_POST["username"];
    $password = $_POST["password"];
    $selectedState = $_POST['std']; 
    
    // Retrieve voter details including location
    $sql = "SELECT * FROM voters_details WHERE voter_id='{$voterid}' AND dob='{$password}'";
    $result = mysqli_query($db_connection, $sql);

    if(mysqli_num_rows($result) == 1) {
        // Voter ID and password are correct
        $row = mysqli_fetch_assoc($result);
        $storedState = $row['location'];

        // Verify if the stored state matches the selected state
        if($selectedState === $storedState) {
            session_start();
            $_SESSION['username'] = $voterid;
            // Redirect to a logged-in page
            header("Location: voting_page.php?state=" . urlencode($selectedState));     
            exit();
        } else {
            // Location does not match the selected state, display an error message
            echo '<script>alert("The selected state does not match your registered location. Please try again.")</script>';
        }
    } else {
        // Credentials are incorrect, display an error message
        echo '<script>alert("Incorrect voter ID or password. Please try again.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP voting system</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('https://t4.ftcdn.net/jpg/04/83/32/57/360_F_483325706_Yy9uS1qzLVKPeNZvefGfJnhscRDb6VW8.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    /* background-position: center; */
} 



        .voting-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .voting-container h1 {
            color: #007bff; /* Change the color to a nice blue (#007bff) */
            margin-bottom: 20px;
            font-weight: bold; /* Make the text bold */
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            margin: 0 auto;
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container p {
            margin-top: 20px;
            color: #888;
        }

        .login-container select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="voting-container">
        <h1>VOTING SYSTEM</h1>
    </div>    
    <div class="login-container">
        <h1>Login</h1>
        <form action="index.php" method="post">
            <input type="text" name="username" placeholder="Voter ID" required>
            <input type="password" name="password" placeholder="DOB" required>
            <select name="std" required>
                <option value="" disabled selected>Select your state</option>   
                <option value="Andhra Pradesh">Andhra Pradesh</option>     
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            <br>
            <br>
            <button type="submit">Login</button>
            <br>
            <br>
            <p> Don't have an account? <a href="http://localhost/voting/registration.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
