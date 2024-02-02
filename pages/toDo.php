<?php
    session_start();
    include '/home/mingligr/328TeamProjectDB.php';

    // If not logged in, return them to the home page
    if(!isset($_SESSION["username"])) {
        header("Location: /328/SDEV328_TeamProject/index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] = "POST") {
        // If the user presses create a new management btn
        if(isset($_POST["createNewManagementAddBtn"])) {
            $newManagementName = $_POST["createNewManagementName"];
            $userId = $_SESSION["userID"];

            $sql = "INSERT INTO managements (managements_title, user_id)
                    VALUES ('$newManagementName', '$userId')";


            mysqli_query($connection, $sql);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $sql);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If the user presses management btn
        else if (isset($_POST["managementsTitleSelect"])) {
            $managementsID = $_POST["managementsID"];

            $_SESSION["managementID"] = $_POST["managementsID"];
        }
        // If the user presses delete management btn
        else if (isset($_POST["managementsDeleteBtn"])) {
            $managementsID = $_POST["managementsID"];

            $managementDeleteSQL = "DELETE FROM managements
                    WHERE managements_id = $managementsID";

            mysqli_query($connection, $managementDeleteSQL);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $managementDeleteSQL);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If user presses create new list
        else if (isset($_POST["createNewList"])) {
            $userId = $_SESSION["userID"];
            $managementsID = $_SESSION["managementID"];


            $createNewListSQL = "INSERT INTO listView (listView_text, user_id, managements_id)
                VALUES('New List', '$userId', '$managementsID')";

            mysqli_query($connection, $createNewListSQL);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $createNewListSQL);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If user wants to delete a list
        else if (isset($_POST["listDelete"])) {
            $listViewID = $_POST["listID"];

            // Deletes the list
            $listDeleteSQL = "DELETE FROM listView
                    WHERE listView_id = $listViewID";

            mysqli_query($connection, $listDeleteSQL);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $listDeleteSQL);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If user presses add bullet to the list
        else if (isset($_POST["listBulletAdd"])) {
            $listID = $_POST["listID"];

            $createNewListBulletSQL = "INSERT INTO listBullets (listBullets_text, listBullets_checked, listView_id)
                VALUES('Text Here', '0', '$listID');
            ";
            mysqli_query($connection, $createNewListBulletSQL);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $createNewListBulletSQL);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If user checks a list bullet
        else if (isset($_POST["listCheck"])) {
            $listBulletsID = $_POST["listBulletsID"];

            $update = "UPDATE listBullets
            SET listBullets_checked = NOT listBullets_checked
            WHERE listBullets_id = $listBulletsID
            ";
            mysqli_query($connection, $update);
            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
            // try {
            //     mysqli_query($connection, $update);
            //     header("Location: /phpLearning/SDEV328_TeamProject/pages/toDo.php");
            // }
            // catch(mysqli_sql_exception) {
            //     echo "Did not work";
            // }
        }
        // If user edits the list text
        else if (isset($_POST["confirmListEditBtn"])) {
            $listID = $_POST["listID"];
            $listTitleNameInput = $_POST["listTitleNameInput"];

            // Title Name
            $updateListTitleSQL = "UPDATE listView
            SET listView_text = '$listTitleNameInput'
            WHERE listView_id = $listID";

            mysqli_query($connection, $updateListTitleSQL);

            // Loop for each bullet in the list
            foreach($_POST["bullets"] as $key => $bulletValue) {
            $bulletText = $_POST["bulletText" . $bulletValue];

                $updateListBulletTextSQL = "UPDATE listBullets
            SET listBullets_text = '$bulletText'
            WHERE listBullets_id = $bulletValue";

                mysqli_query($connection, $updateListBulletTextSQL);
            }

            header("Location: /328/SDEV328_TeamProject/pages/toDo.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To Do</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/nav.css">
        <link rel="stylesheet" href="../css/toDo.css">
        <script src="../js/navbar.js" defer></script>
        <script src="../js//managementSidePanel.js" defer></script>
    </head>

    <body>
        <?php include("../common/nav.php") ?>

        <!-- managements -->
        <div id="managements">
            <div id="createNewManagementUserBtns" class="listUserBtns">
                <button id="newManagementBtn" type="button" name="createNewList">  <span class="material-symbols-outlined"> add </span> New Management</button>
                <button id="managementPanelCloseBtn" type="button">  <span class="material-symbols-outlined"> arrow_back_ios_new </span>Close</button>
            </div>

            <form id="createNewManagementContainer" class="hidden" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input type="text" name="createNewManagementName">
                <input type="submit" name="createNewManagementAddBtn" value="Add">
            </form>

            <div>
                <?php
                    $userId = $_SESSION["userID"];

                    $sql = "SELECT * FROM managements
                    WHERE user_id = $userId
                    ORDER BY managements_title ASC;";

                    $result = mysqli_query($connection, $sql);

                    // for each of the managements if the certain user, it would be shown here
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = '';

                            if (isset($_SESSION["managementID"])) {
                                if($_SESSION["managementID"] == $row["managements_id"]) {
                                    $selected = "selected";
                                }
                            }

                            echo '
                            <form class="managementsSelections" action=' . htmlspecialchars($_SERVER["PHP_SELF"]) . ' method="post">
                                <div>
                                    <input type="hidden" name="managementsID" value='. $row["managements_id"].' >
                            
                                    <button type="submit" class= "'. $selected . '" name="managementsTitleSelect">'. $row["managements_title"] .'</button>
                            
                                    <button class="managementsSelectionsEdit" type="button"><span class="material-symbols-outlined"> edit </span></button>
                            
                                    <button class="managementsSelectionsEdit" type="submit" name="managementsDeleteBtn"><span class="material-symbols-outlined"> delete </span></button>
                                </div>
                            </form>
                            ';
                        }
                    }
                ?>
            </div>
        </div>

        <!-- Lists -->
        <div class="wrapper">
            <form class="listUserBtns" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <button id="managementPanelOpenBtn" type="button">  <span class="material-symbols-outlined"> arrow_forward_ios</span>Management</button>

                <?php
                    if (isset($_SESSION["managementID"])) {
                        echo '
                            <button type="submit" name="createNewList">  <span class="material-symbols-outlined"> add </span> Create New List</button>

                            <button type="button" name="inviteToList">  <span class="material-symbols-outlined"> person_add </span> Invite</button>
                        ';
                    }
                ?>
            </form>

            <!-- Edit List -->
            <?php
            // If the user presses editTitle, they will show a form to edit text of title and bullets :D
            if(isset($_POST["editTitle"])) {
                $listID = $_POST["listID"];

                $sql = "SELECT * FROM listView
                    WHERE listView_id = $listID";

                $result = mysqli_query($connection, $sql);



                echo "<form id='cardEditContainer' class='card' action=". htmlspecialchars($_SERVER["PHP_SELF"]) ." method='post'>";

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <div class='cardTitle'>
                            <input type='hidden' name='listID' value=" . $row["listView_id"] . ">

                            <input type='text' name='listTitleNameInput' value=". $row['listView_text'] . ">

                            <button type='submit' name='confirmListEditBtn'>
                                <span class='material-symbols-outlined'> check </span>
                            </button>
                        </div>
                        
                        <div class='cardEditLists'>";

                        // For each bullet in the list
                        $listBulletsSQL = "SELECT * FROM listBullets
                            WHERE listView_id = $row[listView_id]
                            ORDER BY listBullets_text ASC;";

                        $listBulletsResult = mysqli_query($connection, $listBulletsSQL);

                        if (mysqli_num_rows($listBulletsResult) > 0) {
                            while ($bullet = mysqli_fetch_assoc($listBulletsResult)) {
                                echo "
                                    <div>
                                        <input type='hidden' name='bullets[]' value='".$bullet['listBullets_id']."' >
                                        <input type='text' name='bulletText".$bullet['listBullets_id']."' value='".$bullet['listBullets_text']."' >
                                    </div>
                                    ";
                            }
                        };

                        echo"</div>
                    </form>";
                    }
                }

                echo "</form>";
            }
            ?>



            <div>
            <?php
                // checks to see if there is a managementID, if not no need to run the following
                if (isset($_SESSION["managementID"])) {
                    $userId = $_SESSION["userID"];
                    $managementsID = $_SESSION["managementID"];

                    $sql = "SELECT * FROM listView
                    WHERE user_id = $userId
                    AND managements_id = $managementsID
                    ORDER BY listView_id ASC";

                    $result = mysqli_query($connection, $sql);

                    // for each of the managements if the certain user, it would be shown here
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <article class='card'>
                                <div class='cardTitle'>
                                    <h3>$row[listView_text]</h3>

                                    <form class='cardLists' action=" . htmlspecialchars($_SERVER['PHP_SELF']) ." method='post'>
                                        <input type='hidden' name='listID' value=" . $row["listView_id"] . ">

                                        <button type='submit' name='editTitle'>
                                            <span class='material-symbols-outlined'> edit </span>
                                        </button>

                                        <button type='submit' name='listBulletAdd'>
                                            <span class='material-symbols-outlined'> add </span>
                                        </button>

                                        <button type='submit' name='listDelete'>
                                            <span class='material-symbols-outlined'> delete </span>
                                        </button>
                                    </form>
                                    
                                </div>

                                <form class='cardLists' action=" . htmlspecialchars($_SERVER['PHP_SELF']) ." method='post'>
                                    <input type='hidden' name='listID' value=" . $row["listView_id"] . ">";

                                    // For each bullet in the list
                                    $listBulletsSQL = "SELECT * FROM listBullets
                                    WHERE listView_id = $row[listView_id]
                                    ORDER BY listBullets_text ASC;";

                                    $listBulletsResult = mysqli_query($connection, $listBulletsSQL);

                                    if (mysqli_num_rows($listBulletsResult) > 0) {
                                        while ($bullet = mysqli_fetch_assoc($listBulletsResult)) {
                                            $checked = '';

                                            if ($bullet["listBullets_checked"]) {
                                                $checked = "<span class='material-symbols-outlined'> radio_button_checked </span>";
                                            }
                                            else {
                                                $checked = "<span class='material-symbols-outlined'> radio_button_unchecked </span>";
                                            }

                                            echo "
                                            <form class='cardLists' action=" . htmlspecialchars($_SERVER['PHP_SELF']) ." method='post'>
                                                <button type='submit' name='listCheck'>
                                                    <input type='hidden' name='listBulletsID' value= " . $bullet["listBullets_id"] . " >

                                                    $checked
                                                </button> 
                                                <p>$bullet[listBullets_text]</p>
                                            </form>
                                            ";
                                        }
                                    }

                                    echo "
                                </form>
                            </article>
                            ";
                        }
                    }
                }
            ?>
            </div>
        </div>
    </body>
</html>