<?php 
    session_start();
    include '/home/mingligr/328TeamProjectDB.php';

    if (isset($_SESSION["username"])) {
        header("Location: /328/SDEV328_TeamProject/pages/posts.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Productivity</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="./css/global.css">
        <link rel="stylesheet" href="./css/nav.css">
        <link rel="stylesheet" href="./css/home.css">
        <script src="./js/navbar.js" defer></script>
    </head>

    <body >
        <?php include("./common/nav.php") ?>

        <div class="wrapper">
            <main>
                <header>
                    <h1>Want to organize your <span>Work</span> and <span>Life</span>?</h1>
                    <p>Manage your To-Do list, project management, or time blocking with <span>Productivity</span>. The bests organize app in the world!</p>
                </header>
            </main>
        </div>
    </body>
</html>