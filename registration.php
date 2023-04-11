<!DOCTYPE html>
<html>
<head>
	<title>User Profile Registration</title>
    <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Verdana:wght@700&display=swap" rel="stylesheet">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/global.css" />
    <style>
        .registration-box {
            padding: 20px;
            border-radius: 16px;
            background-color: green;
            text-align: center;
        }
        h1 {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #fff;
        }
		form {
			display: inline-block;
			padding: 20px;
			border-radius: 16px;
			background-color: white;
		}
		label {
			display: inline-block;
			margin-right: 10px;
			margin-bottom: 10px;
		}
		label img {
			width: 50px;
			height: 50px;
		}
		input[type="text"] {
			padding: 10px;
			font-size: 16px;
			border-radius: 8px;
			border: 2px solid green;
			margin-bottom: 20px;
            width: 260px;
		}
		input[type="submit"] {
			font-size: 24px;
			padding: 15px 30px;
            background-color: #F70B74;
			border: none;
            border-radius: 0.3em;
			color: #fff;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: #d32f2f;
		}
		.error {
			color: red;
			font-size: 12px;
			margin-top: -10px;
			margin-bottom: 20px;
		}
    </style>
</head>
<body>
    <?php
        include('navbar.php');
        session_start();
    ?>
	<div id="main" class="default-container">
        <div class="registration-box">
        <h1>User Profile Registration</h1>
        <form method="post">
            <label for="username">Username/nickname:</label>
            <div>
                <input type="text" name="username" id="username">
            </div>
            <?php
                if (isset($_POST['username'])) {
                    $invalid_chars = array("!", "@", "#", "%", "^", "&", "*", "(", ")", "+", "=", "{", "}", "[", "]", "-", ";", ":", "\"", "'", "<", ">", "?", "/");
                    $username = $_POST['username'];
                    if (strpbrk($username, implode("", $invalid_chars)) !== false) {
                        echo '<div class="error">Invalid characters detected in username. <br> Please enter a new username.</div>';
                    }
                }
            ?>
            <div>
                <label for="avatar">Avatar Generator:</label>
            </div>
            <div>
                <label><input type="radio" id="background1" name="background" value="yellow.png" onchange="previewAvatar()" checked> <img src="img/yellow.png" alt="Yellow background"></label>
                <label><input type="radio" id="background2" name="background" value="red.png" onchange="previewAvatar()"> <img src="img/red.png" alt="Red background"></label>
                <label><input type="radio" id="background3" name="background" value="green.png" onchange="previewAvatar()"> <img src="img/green.png" alt="Green background"></label>
            </div>

            <div>
                <label><input type="radio" id="eyes1" name="eyes" value="closed.png" onchange="previewAvatar()" checked> <img src="img/closed.png" alt="Closed eyes"></label>
                <label><input type="radio" id="eyes2" name="eyes" value="laughing.png" onchange="previewAvatar()"> <img src="img/laughing.png" alt="Laughing eyes"></label>
                <label><input type="radio" id="eyes3" name="eyes" value="long.png" onchange="previewAvatar()"> <img src="img/long.png" alt="Long eyes"></label>
                <label><input type="radio" id="eyes4" name="eyes" value="normal.png" onchange="previewAvatar()"> <img src="img/normal.png" alt="Normal eyes"></label>
                <label><input type="radio" id="eyes5" name="eyes" value="rolling.png" onchange="previewAvatar()"> <img src="img/rolling.png" alt="Rolling eyes"></label>
                <label><input type="radio" id="eyes6" name="eyes" value="winking.png" onchange="previewAvatar()"> <img src="img/winking.png" alt="Winking eyes"></label>
            </div>

            <div>
                <label><input type="radio" id="smile1" name="smile" value="smiling.png" onchange="previewAvatar()" checked> <img src="img/smiling.png" alt="Smiling smile"></label>
                <label><input type="radio" id="smile2" name="smile" value="straight.png" onchange="previewAvatar()"><img src="img/straight.png" alt="Straight smile"></label>
                <label><input type="radio" id="smile3" name="smile" value="sad.png" onchange="previewAvatar()"> <img src="img/sad.png" alt="Sad smile"></label>
                <label><input type="radio" id="smile4" name="smile" value="surprise.png" onchange="previewAvatar()"> <img src="img/surprise.png" alt="Surprise smile"></label>
                <label><input type="radio" id="smile5" name="smile" value="teeth.png" onchange="previewAvatar()"> <img src="img/teeth.png" alt="Teeth smile"></label>
                <label><input type="radio" id="smile6" name="smile" value="open.png" onchange="previewAvatar()"> <img src="img/open.png" alt="Open smile"></label>
            </div>
            <div>
                <label for="avatar">Preview:</label>
            </div>
            <div>
                <img id="avatar_preview" src="" alt="Avatar preview">
            </div>
            <br>
            <input type="submit" value="Register">
        </form>
        <?php
            $finished = false;
            if (isset($_POST['username'])) {
                $username = $_POST['username'];
                $background = $_POST['background'];
                $eyes = $_POST['eyes'];
                $smile = $_POST['smile'];
                $data = array("background" => $background, "eyes" => $eyes, "smile" => $smile);
                
                if (!strpbrk($username, implode("", $invalid_chars))) {
                    $_SESSION['username'] = $username;
                    $_SESSION['avatar'] = $data;
                    $finished = true;
                }
            }
            echo "<div id='finished' data-value='" . $finished . "'></div>";
        ?>
        </div>
    </div>
    <script>
        const backgrounds = ["yellow.png", "red.png", "green.png"];
        const eyes = ["closed.png", "laughing.png", "long.png", "normal.png", "rolling.png", "winking.png"];
        const smiles = ["sad.png", "smiling.png", "straight.png", "surprise.png", "teeth.png", "open.png"];
        previewAvatar();
        function previewAvatar() {
            const background = document.querySelector('input[name="background"]:checked').value;
            const eyes = document.querySelector('input[name="eyes"]:checked').value;
            const smile = document.querySelector('input[name="smile"]:checked').value;

            const canvas = document.createElement('canvas');
            canvas.width = 50;
            canvas.height = 50;
            const ctx = canvas.getContext('2d');

            const backgroundImg = new Image();
            backgroundImg.onload = () => {
                ctx.drawImage(backgroundImg, 0, 0, 50, 50);
                const eyesImg = new Image();
                eyesImg.onload = () => {
                    ctx.drawImage(eyesImg, 0, 0, 50, 50);
                    const smileImg = new Image();
                    smileImg.onload = () => {
                        ctx.drawImage(smileImg, 0, 0, 50, 50);
                        const avatarPreview = document.getElementById('avatar_preview');
                        avatarPreview.src = canvas.toDataURL();
                    };
                    smileImg.src = `img/${smile}`;
                };
                eyesImg.src = `img/${eyes}`;
            };
            backgroundImg.src = `img/${background}`;
        }
        
        const mainData = document.getElementById("finished");
        var data = mainData.getAttribute("data-value");
        console.log(data)
        if (data == true) {
            moveHome();
        }
        function moveHome() {
            window.location.href = '/index.php';
        }
    </script>
</body>
</html> 
