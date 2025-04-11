<?php
    include_once "../controller/user_controller.php";
    include_once "common_display.php";
    include_once "../config/config_variables.php";
    session_start();
    if(array_key_exists("user", $_SESSION)) { header("Location: ../index.php"); }
    if(isset($_POST["signup"]))
    {
        $error_messages = UserController::get_instance()->signup($_POST["name"], $_POST["email"], $_POST["birth_date"], $_POST["password"], $_POST["password_again"]);
        if(!count($error_messages)) { header("Location: login.php"); }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>
<body>
    <form action="#" method="POST">
        <fieldset>
            <legend>Regisztráció</legend>
            <label>Felhasználónév: <input type="text" name="name" required></label>
            <br>
            <label>Email: <input type="email" name="email" required></label>
            <br>
            <label>Születési idő: <input type="text" name="birth_date" placeholder="yyyy-mm-dd" required></label>
            <br>
            <label>Jelszó: <input type="password" name="password" required></label>
            <br>
            <label>Jelszó újra: <input type="password" name="password_again" required></label>
            <br>
            <?php
                if(isset($error_messages))
                {
                    Display::print_errors($error_messages);
                }
            ?>
            <input type="submit" name="signup" value="Regisztráció">
            <p>Már van fiókja?</p>
            <input type="button" onclick="location.href='login.php'" value="Bejelentkezés">
        </fieldset>
    </form>

</body>
</html>