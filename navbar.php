<!DOCTYPE html>
<html>
<head>
	<title>Navbar</title>
	<link href="https://fonts.googleapis.com/css2?family=Verdana:wght@700&display=swap" rel="stylesheet">
	<style>
		.navbar {
			background-color: blue;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			padding: 10px;
			font-family: 'Verdana', sans-serif;
			font-size: 12px;
			font-weight: bold;
			z-index: 9999;
            display: flex;
            justify-content: space-between;
		}

        .nav1 {
            margin-right: 20px;
        }

		.nav1 ul {
			margin: 0;
			padding: 0;
			list-style: none;
			display: flex;
            flex-wrap : wrap ;
		}

		.nav1 li {
			margin: 5px 10px;
		}

		.nav1 a {
			color: #fff;
			text-decoration: none;
		}
	</style>
</head>
<body>
    <div class="navbar">
        <div class="nav1">
            <ul>
                <li><a href="index.php" name="home">Home</a></li>
            </ul>
        </div>
        <div class="nav1">
            <ul>
                <li><a href="pairs.php" name="memory">Play Pairs</a></li>
                <?php
                    session_start();
                    // check if user has registered a profile
                    $username = "";
                    $json_data = "";
                    $data = "";
                    if(isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                    }
                    if ($username) {
                        echo '<li><a href="leaderboard.php" name="leaderboard">Leaderboard</a></li>';
                        if(isset($_SESSION['avatar'])) {
                            $data = $_SESSION['avatar'];
                            echo '<li><img id="avatar" alt="Avatar preview"></li>';
                            $json_data = json_encode($data);
                        }
                    } else {
                        echo '<li><a href="registration.php" name="register">Register</a></li>';
                    }
                ?>
                <script>
                    var data = <?php echo $json_data; ?>;
                    if (data) {
                        previewAvatar(data);
                    }
                    function previewAvatar(data) {
                        const background = data.background;
                        const eyes = data.eyes;
                        const smile = data.smile;

                        const canvas = document.createElement('canvas');
                        canvas.width = 15;
                        canvas.height = 15;
                        const ctx = canvas.getContext('2d');

                        const backgroundImg = new Image();
                        backgroundImg.onload = () => {
                            ctx.drawImage(backgroundImg, 0, 0, 15, 15);
                            const eyesImg = new Image();
                            eyesImg.onload = () => {
                                ctx.drawImage(eyesImg, 0, 0, 15, 15);
                                const smileImg = new Image();
                                smileImg.onload = () => {
                                    ctx.drawImage(smileImg, 0, 0, 15, 15);
                                    const avatarPreview = document.getElementById('avatar');
                                    avatarPreview.src = canvas.toDataURL();
                                };
                                smileImg.src = `img/${smile}`;
                            };
                            eyesImg.src = `img/${eyes}`;
                        };
                        backgroundImg.src = `img/${background}`;
                    }
                </script>
            </ul>
        </div>
	</div>
</body>
</html>
