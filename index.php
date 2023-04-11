<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Pairs</title>
    <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Verdana:wght@700&display=swap" rel="stylesheet">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/global.css" />
    <style>
        .home-box {
            padding: 50px;
            border-radius: 16px;
            background-color: #0166EC;
            text-align: center;
        }
        h1 {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #fff;
        }
        button {
            font-size: 24px;
            background-color: #F70B74;
            border-radius: 0.3em;
            padding: 1em 1.5em;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #d32f2f;
        }
        p {
            margin-bottom: 30px;
        }
        a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
        include('navbar.php');
    ?>
	<div id="main" class="default-container">
        <div class="home-box">
            <?php 
                $username = "";
                if(isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                }
                if($username !== "") {
                    echo "<h1>Welcome to Pairs, $username!</h1>";
                    echo "<a href='pairs.php'><button>Click here to play</button></a>";
                } else {
                    echo "<h1>Welcome to Pairs</h1>";
                    echo "<p>You're not using a registered session? <a href='registration.php'>Register now</a></p>";
                }
            ?>
        </div>
    </div>
</body>
</html> 
