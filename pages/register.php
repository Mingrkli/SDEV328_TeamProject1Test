<?php 
    session_start();
    include '/home/mingligr/328TeamProjectDB.php';

    // placeholders for errors 
    $email =
    $username =
    $password =
    $passwordConfirm ="";

    $thankYou = "";

    $errors = array(
        "email" => "",
        "username" => "",
        "password" => "",
        "passwordConfirm" => ""
    );

    if ($_SERVER["REQUEST_METHOD"] = "POST") {
        if (isset($_POST["registerBtn"])) {
            // email
            if (empty($_POST["registerEmail"]) || !filter_var($_POST["registerEmail"], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Not a valid email";
            }
            else {
                $email = $_POST["registerEmail"];
            }

            // username
            if (empty($_POST["registerUsername"])) {
                $errors["username"] = "Not a valid username";
            }
            else {
                $username = $_POST["registerUsername"];
            }

            // password
            if (empty($_POST["registerPassword"])) {
                $errors["password"] = "Not a valid password";
            }
            else {
                $password = $_POST["registerPassword"];
            }
    
            // passwordConfirm
            if ($_POST["registerPasswordConfirm"] != $_POST["registerPassword"]) {
                $errors["passwordConfirm"] = "Passwords not the same";
            }
            else {
                $passwordConfirm = $_POST["registerPasswordConfirm"];
            }

            // If there are no errors basically, try to insert the new user into the database and fail if there is already a username/email with the same name
            if(!array_filter($errors)) {
                $email = filter_input(INPUT_POST, "registerEmail", FILTER_VALIDATE_EMAIL);
                $username = filter_input(INPUT_POST, "registerUsername", FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, "registerPassword", FILTER_SANITIZE_SPECIAL_CHARS);
                $hash = password_hash($password, PASSWORD_DEFAULT);
    
                
                $sql = "INSERT INTO accounts (username, email, password)
                        VALUES ('$username', '$email' , '$hash')";

                mysqli_query($connection, $sql);
                // header("Location: /328/SDEV328_TeamProject/pages/thankYou.php");
                $thankYou = '<h3><span class="material-symbols-outlined"> check_circle </span> You are now registered!</h3>';
                
                // try {
                //     mysqli_query($connection, $sql);
                //     $_SESSION["username"] = $username;
                //     header("Location: /phpLearning/SDEV328_TeamProject/pages/thankYou.php");
                // } 
                // catch(mysqli_sql_exception) {
                //     echo "That Username/Email is already taken";
                // }
            }
        }
    }
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

        <div class="wrapper">
            <?php echo $thankYou ?>
            <h3>Register New Account</h3>
            <div id="registerView">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <label>Email</label>
                    <div class="error-text"><?php echo $errors["email"]; ?></div>
                    <input type="text" name="registerEmail" placeholder="123@gmail.com" value="<?php echo $email; ?>">

                    <label>Username</label>
                    <div class="error-text"><?php echo $errors["username"]; ?></div>
                    <input type="text" name="registerUsername" placeholder="123" value="<?php echo $username; ?>">
    
                    <label>Password</label>
                    <div class="error-text"><?php echo $errors["password"]; ?></div>
                    <input type="password" name="registerPassword" >

                    <label>Password Confirm</label>
                    <div class="error-text"><?php echo $errors["passwordConfirm"]; ?></div>
                    <input type="password" name="registerPasswordConfirm" >
    
                    <input type="submit" name="registerBtn" value="Register">
                </form>
            </div>
        </div>
        
    </body>
</html>