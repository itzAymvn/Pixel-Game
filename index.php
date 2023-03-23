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

    <style>
        header {
            display: flex;
            padding: 1em;
            justify-content: space-between;
            align-items: center;
            gap: 1em;
        }

        header h1 {
            font-size: 2rem;
            color: #fff;
        }

        header a {
            text-decoration: none;
            color: #fff;
            font-size: 1.5rem;
            padding: 10px 20px;
            background-color: #000;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        header a:hover {
            background-color: #fff;
            color: #000;
        }
    </style>

    <main>
        <div class="board" id="board"></div>
        <?php
        if (isset($_SESSION['player'])) {
        ?>
            <div class="sidebar" id="sidebar">
                <div class="color-select">
                    <h2>Select a color</h2>
                    <div class="colors" id="colors"></div>
                </div>
                <h2 class="timer-div">Timer: <span id="timer"></span></h2>
            </div>
        <?php
        }
        ?>
    </main>

    <footer>
        <p>© 2023 Ayman</p>
    </footer>

    <script src="src/index.js" defer></script>

</body>

</html>