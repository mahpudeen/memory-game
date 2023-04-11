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

        // Terima data yang dikirimkan dari JavaScript
        $data = json_decode(file_get_contents('php://input'), true);

        // Proses data di sini
        $points = $data['points'];
        if($points) {
            $max_elements = 5;

            // Data yang akan disimpan
            $leaderboard_data = $_SESSION['leaderboard'];

            // Tambahkan data baru
            $new_data = array('username' => $username, 'point' => $points);
            $leaderboard_data[] = $new_data;

            // Urutkan $leaderboard_data berdasarkan point
            usort($leaderboard_data, function($a, $b) {
                return $b['point'] - $a['point'];
            });

            // Cek apakah jumlah elemen di dalam $leaderboard_data lebih besar dari batas maksimum
            if (count($leaderboard_data) > $max_elements) {
                // Jika ya, hapus elemen terakhir
                array_pop($leaderboard_data);
            }

            $_SESSION['leaderboard'] = $leaderboard_data;
            header('Location: leaderboard.php');
            exit();
        }

        // Kirim respons kembali ke JavaScript
        $response = array('status' => 'success');
        echo json_encode($response);
    ?>
    <?php
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
                <!-- <button id="stop" class="hide">Stop Game</button> -->
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
