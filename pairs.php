<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Memory Game</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
        rel="stylesheet"
    />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/pair.css" />
    <link rel="stylesheet" href="css/global.css" />
</head>
<body>
    <?php
        include('navbar.php');
        header("Cache-Control: no-cache, must-revalidate");

        session_start();
        $username = $_SESSION['username'];
        $isLoggedIn = isset($_SESSION['username']);

        // Receive data sent from JavaScript
        $data = json_decode(file_get_contents('php://input'), true);

        // Process the data here
        $points = $data['points'];
        if($points) {
            $max_elements = 5;

            // Data to be stored
            $leaderboard_data = $_SESSION['leaderboard'];

            // Add new data
            $new_data = array('username' => $username, 'point' => $points);
            $leaderboard_data[] = $new_data;

            // Sort $leaderboard_data by point
            usort($leaderboard_data, function($a, $b) {
                return $b['point'] - $a['point'];
            });

            // Check if the number of elements in $leaderboard_data is greater than the maximum limit
            if (count($leaderboard_data) > $max_elements) {
                // If yes, remove the last element
                array_pop($leaderboard_data);
            }

            $_SESSION['leaderboard'] = $leaderboard_data;
            header('Location: leaderboard.php');
            exit();
        }

        // Send response back to JavaScript
        $response = array('status' => 'success');
        echo json_encode($response);

        // Generate HTML code for a div with a data-value attribute
        echo "<div id='user-data' data-value='" . $isLoggedIn . "'></div>";
    ?>
    <div id="main">
        <div class="wrap-container">
            <div class="wrapper">
                <div class="stats-container">
                    <p id="moves-count" class="flips"></p>
                    <p id="time" class="time"></p>
                    <p id="point"></p>
                </div>
                <div class="game-container"></div>
            </div>
        </div>
        <div class="controls-container">
            <p id="result"></p>
            <div class="btn-control">
                <button id="submit" class="btn-submit">Submit</button>
                <button id="start" class="btn-start">Start Game</button>
            </div>
        </div>
    </div>
    <!-- Script -->
    <script src="script/pair.js"></script>
</body>
</html>
