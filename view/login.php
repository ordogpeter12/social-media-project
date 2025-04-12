<?php
    session_start();
    include_once "common_display.php";
    include_once "../dao/user_dao.php";
    include_once "../controller/user_controller.php";
    if(array_key_exists("user", $_SESSION)) { header("Location: ../index.php"); }
    if(isset($_POST["login"]))
    {
        /*Sikeres bejelentkezés esetnén a $_SESSION tömben "user" kulccsal elérhető
        a bejelentkezett felhasználó User object-je*/
        $error_messages = UserController::get_instance()->login($_POST["email"], $_POST["password"]);
        if(!count($error_messages)) { header("Location: profile.php"); }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
</head>
<body>
    <form action="#" method="POST">
        <fieldset class="user_info">
            <legend>Bejelentkezés</legend>
            <label>Email: <input type="text" name="email" required></label>
            <br>
            <label>Jelszó: <input type="password" name="password" required></label>
            <br>
            <?php
                if(isset($error_messages))
                {
                    Display::print_errors($error_messages);
                }
            ?>
            <input type="submit" value="Bejelentkezés" name="login">
            <p>Nincs még fiókja?</p>
            <input type="button" onclick="location.href='signup.php'" value="Regisztráció">
        </fieldset>
    </form>
</body>
</html>