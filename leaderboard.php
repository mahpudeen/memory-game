<!DOCTYPE html>
<html>
<head>
	<title>Leaderboard</title>
    <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Verdana:wght@700&display=swap" rel="stylesheet">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/global.css" />
    <style>
        .leaderboard-box {
            padding: 20px;
            border-radius: 16px;
            width: 400px;
            background-color: green;
            text-align: center;
            background-color: grey; 
            box-shadow: 5px 5px 5px grey;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 2px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: blue;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ddd;
        }
        caption {
            font-size: 1.2em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
        include('navbar.php');
        session_start();
        $leaderboard_data = $_SESSION['leaderboard'];
    ?>
	<div id="main" class="default-container">
        <div class="leaderboard-box">
        <table>
            <caption>Leaderboard</caption>
            <thead>
                <tr>
                    <th class="center" style="width: 8%;">#</th>
                    <th class="center">Username</th>
                    <th class="center">Points</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($leaderboard_data)): ?>
                    <?php $counter = 1; ?>
                    <?php foreach ($leaderboard_data as $row): ?>
                        <tr>
                            <td class="center"><?php echo $counter++; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td class="center"><?php echo $row['point']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="center">No data available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html> 
