<?php
if ($_SERVER["REQUEST_METHOD"] = "POST") {
    // When log in btn is pressed, we will check the database if the username/password is correct
    if(isset($_POST["logInBtn"])) {
        $email = filter_input(INPUT_POST, "LogInUsernameEmail", FILTER_SANITIZE_EMAIL);
        $username = filter_input(INPUT_POST, "LogInUsernameEmail", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "logInPassword", FILTER_SANITIZE_SPECIAL_CHARS);


        // The following selects that user that logged in using username or email from the objects of accounts in the database where the username/email is the same :D
        $sql = "SELECT * FROM accounts WHERE username = ? OR email = ?";
        $stmt = mysqli_stmt_init($connection);
        // Checks if the prepared the prepared statement fails
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        }
        else {
            // Bind parameters to the placeholder
            // two s in "ss" since one for username and email and s means String
            // $username / $password is what we would insert into the ? and the cool thing is that we can get the username or the email :D
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            // Renders the code of the username and password which we need to replace the ? inside the database
            mysqli_stmt_execute($stmt);
            // Gets the results from the execute and I'm gonna save it to a variable :D
            $resultData = mysqli_stmt_get_result($stmt);

            // If there is a row that got returned
            if ($row = mysqli_fetch_assoc($resultData)) {
                $userPassword = $row["password"];
                $checkUserPassword = password_verify($password, $userPassword);

                if ($checkUserPassword == false) {
                    echo "Wrong password";
                }
                else if ($checkUserPassword == true) {
                    $_SESSION["userID"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    // If your in the home page, this basically stops it from resubmitting the form
                    header('Location: /328/SDEV328_TeamProject/index.php');
                }
            }
            else {
                echo "There is no account with that Username/Email";
            }
        }
    }

    // If the session status is active and the log out btn is pressed, logs user out of session
    if(isset($_POST['logOutBtn']) && session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
        header("Location: /328/SDEV328_TeamProject/index.php");
    }
}
?>

<nav>
    <a id="logo" href="/328/SDEV328_TeamProject/index.php">Productivity</a>

    <?php
    if(isset($_SESSION["username"])) {
        echo '
            <div>
                <a href="/328/SDEV328_TeamProject/pages/posts.php">Posts</a>
                <a href="/328/SDEV328_TeamProject/pages/toDo.php">To-Do</a>
            </div>
            ';
    }
    ?>


    <p>
        <?php echo (isset($_SESSION["username"])) ? $_SESSION["username"] : ''  ?> <span id="accountIcon" class="icon material-symbols-outlined">
            account_circle
        </span>
    </p>
</nav>

<aside id="navAside" >
    <?php
    if (isset($_SESSION["username"])) {
        echo '
                <section id="logOutBtnContainer">
                    <form action=' . htmlspecialchars($_SERVER["PHP_SELF"]) .' method="post">
                        
                        <input id="logOutBtn" type="submit" name="logOutBtn" value="Log Out">
                    </form>
                </section>
                ';
    }
    ?>

    <section id="login" class="<?php echo (isset($_SESSION["username"])) ? 'hidden' : ''  ?>" >
        <p id="loginIcon"><span class="icon material-symbols-outlined"> login </span> Login</p>

        <div id="loginView">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <label>Username/Email</label>
                <input type="text" name="LogInUsernameEmail" placeholder="123@gmail.com">

                <label>Password</label>
                <input type="password" name="logInPassword">

                <input type="submit" name="logInBtn" value="Log In">
                <a href="/328/SDEV328_TeamProject/pages/register.php">Create a new account?</a>
            </form>
        </div>
    </section>

    <section id="color-picker">
        <span id="paletteIcon" class="icon material-symbols-outlined"> palette </span>

        <div id="colorPickerContainer">
            <label>Main</label>
            <input class="colorPickerInput mainColor" type="color">

            <label>Secondary</label>
            <input class="colorPickerInput secColor" type="color">

            <label>Text</label>
            <input class="colorPickerInput textColor" type="color">
        </div>
    </section>

    <section id="light-dark-mode">
        <span id="lightModeIcon" class="icon material-symbols-outlined"> light_mode </span>
        <span id="darkModeIcon" class="icon material-symbols-outlined hidden"> dark_mode </span>
    </section>
</aside>