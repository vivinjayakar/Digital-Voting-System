<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .vote-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .candidate-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .candidate-img {
            max-width: 100px;
            height: auto;
            border-radius: 50%;
            margin-right: 20px;
        }

        .candidate-info {
            flex: 1; /* Take remaining space */
        }

        .candidate-name {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .candidate-location {
            font-size: 14px;
            color: #888;
            margin-bottom: 10px;
        }

        .vote-btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .vote-btn:hover {
            background-color: #0056b3;
        }

        .no-candidates {
            text-align: center;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>
<body>
    <?php
    // Include your database connection file
    include("database.php");

    // Query to select all candidates' names and IDs from the candidate table
    $state = $_GET['state'];
    $sql = "SELECT * FROM voting_list WHERE location = '{$state}'";

    // Execute the query
    $result = mysqli_query($db_connection, $sql);

    // Check if the query was successful
    if($result) {
        // Check if there are any candidates found
        if(mysqli_num_rows($result) > 0) {
            // Output each candidate name as clickable link
            echo '<div class="vote-container">';
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="candidate-item">';
                echo '<img class="candidate-img" src="images/' . $row["image_url"] . '" alt="Candidate Image">';
                echo '<div class="candidate-info">';
                echo '<h3 class="candidate-name">' . $row["candidate_name"] . '</h3>';
                echo '<p class="candidate-location">' . $row["location"] . '</p>';
                echo '</div>';
                echo '<a href="?candidate_name=' . $row["candidate_name"] . '" class="vote-btn">Vote</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="no-candidates">No candidates found.</p>';
        }
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }

    // Check if a candidate's name is clicked
    if(isset($_GET['candidate_name'])) {
        // Increase the number of votes for the selected candidate
        $candidate_name = $_GET['candidate_name'];
        $sql = "UPDATE voting_list SET no_of_votes = no_of_votes + 1 WHERE candidate_name = '{$candidate_name}'";
        if(mysqli_query($db_connection, $sql)) {
            header("Location: success.php");
        } else {
            echo "Error occurred while increasing vote for candidate.";
        }
    }

    // Close the database connection
    mysqli_close($db_connection);
    ?>
</body>
</html>
