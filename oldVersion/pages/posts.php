<?php 
    session_start();
    include '/home/mingligr/328TeamProjectDB.php';

    // If not logged in, return them to the home page
    if(!isset($_SESSION["username"])) {
        header("Location: /328/SDEV328_TeamProject/index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] = "POST") {
        if(isset($_POST["post-delete-btn"])) {
            $postID = $_POST["hiddenRowID"];
    
            $rowDeleteSql = "DELETE FROM posts
                            WHERE posts_id = $postID";
                            
            mysqli_query($connection, $rowDeleteSql);
        }
        else if (isset($_POST["posts-btn"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
            $desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $userID = $_SESSION["userID"];
    
            $sql = "INSERT INTO posts (posts_title, posts_desc, user_id)
                    VALUES ('$title', '$desc', '$userID')";
                  
            mysqli_query($connection, $sql);
            // try {
            //     mysqli_query($connection, $sql);
            //     header("Location: /phplearning/SDEV328_TeamProject/pages/posts.php");
            // }
            // catch (mysqli_sql_exception) {
            //     echo "ERROR!!!";
            // }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Posts</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/nav.css">
        <link rel="stylesheet" href="../css/posts.css">
        <script src="../js/navbar.js" defer></script>
        <script src="../js/post.js" defer></script>
    </head>

    <body>
        <?php include("../common/nav.php") ?>

        <div class="wrapper">
            <!-- Thinking about making a new post btn in the same page -->
            <form id="createPostContainer" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <input class="createPosts-btn" type="button" name="createPosts-btn" value="Add a new post">

                <div id="createPosts-field" class="hidden">
                    <div>
                        <input class="createPosts-btn" type="button" name="createPosts-btn" value="Cancel">
                        <input id="createPostsTitleField" type="text" name="title" placeholder="Title" maxlength="50">
                        <p id="characterLimitTitle"><span>0</span>/50</p>
                        <textarea name="desc" placeholder="Description" maxlength="300"></textarea>
                        <p id="characterLimitDescription"><span>0</span>/300</p>
                        <input type="submit" name="posts-btn" value="Post">
                    </div>
                </div>
            </form>
    
            <?php 
                // Gets all the posts and inner join them with the accounts so that the users who created the post has extra features
                $sql = "SELECT posts.posts_id, posts.posts_title, posts.posts_datetime, posts.posts_desc, accounts.username, accounts.email, accounts.id
                FROM posts INNER JOIN accounts
                ON posts.user_id = accounts.id
                ORDER BY posts.posts_datetime DESC;";

                $result = mysqli_query($connection, $sql);

                // Check the rows if there is more than 0 (if some how all posts are deleted)
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <article>
                            <div>
                                <h3>$row[posts_title]</h3>
                                <p class='by-who'>by $row[username] | <span>$row[posts_datetime]</span></p>
                            </div>
                            <p id='post-text'>$row[posts_desc]</p>";

                            // Check if the id from the database and the userID of the user logged in is the same
                            if ($row["id"] == $_SESSION["userID"]) {
                                echo "
                                <form class='user-posts' action=" . htmlspecialchars($_SERVER["PHP_SELF"]) . " method='post'>
                                    <input type='hidden' name='hiddenRowID' value='$row[posts_id]'>

                                    <span class='material-symbols-outlined post-delete-btn delete-confirm'>Delete</span>

                                    <div class='hidden delete-confirm-final'>
                                        <button class='delete-confirm-final-cancel-btn' type='button' name='post-delete-btn'><span class='material-symbols-outlined post-delete-btn'>Cancel</span></button>

                                        <button class='delete-confirm-final-check-btn type='submit' name='post-delete-btn'><span class='material-symbols-outlined post-delete-btn'>Check</span></button>
                                    </div>
                                </form>
                                ";
                            };

                        echo "</article>";
                    }
                }
            ?>
        </div>

    </body>
</html>