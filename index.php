<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Game</title>
    <link rel="stylesheet" href="src/index.css" />

    <!-- ... -->

    <?php
    if (isset($_SESSION['player'])) {
        $player = $_SESSION['player'];
        echo "<script>var player = {
            id: {$player['id']},
            username: '{$player['username']}',
            lastPlacedPixel : {$player['lastPlacedPixel']},
            role: 'Player'
        }</script>";
    } else {
        echo "<script>var player = 'guest';</script>";
    }
    ?>

    <!-- ... -->

</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['player'])) {
            echo '<h1>Welcome ' . $_SESSION['player']['username'] . '</h1>';
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo '<h1>Welcome Guest</h1>';
            echo '<a href="login.php">Login</a>';
        }
        ?>
    </header>

    <main>
        <div class="board" id="board"></div>

        <div class="sidebar" id="sidebar">
            <?php
            if (isset($_SESSION['player'])) {
            ?>
                <div class="color-select">
                    <h2>Select a color</h2>
                    <div class="colors" id="colors"></div>
                </div>
            <?php
            }
            ?>
            <div class="chart">
                <h2>
                    Colors chart
                </h2>
                <div class="chart-colors" id="chart-colors">
                </div>
            </div>
            <?php
            if (isset($_SESSION['player'])) {
            ?>
                <h2 class="timer-div">Timer: <span id="timer"></span></h2>
            <?php
            }
            ?>
        </div>

        <style>
            .chart {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .chart-colors {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .chart-colors>div {
                display: flex;
                flex-direction: row;
                gap: 0.25rem;
                align-items: center;
                justify-content: center;
            }
        </style>
    </main>


    <footer>
        <p>© 2023 Ayman</p>
    </footer>

    <script src="src/index.js" defer></script>

</body>

</html>