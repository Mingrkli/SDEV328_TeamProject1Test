<?php 
    session_start();
    include '/home/mingligr/328TeamProjectDB.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Productivity Register</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/nav.css">
        <link rel="stylesheet" href="../css/register.css">
        <script src="../js/navbar.js" defer></script>
    </head>

    <body>
        <?php include("../common/nav.php") ?>

        <?php 
            if (isset($_SESSION["username"])) {
                echo '
                <div class="wrapper">
                    <h3><span class="material-symbols-outlined"> check_circle </span> You are now registered!</h3>
                </div>
                ';
            }
            else {
                header("Location: /328/SDEV328_TeamProject/index.php");
            }
        ?>
        
    </body>
</html>