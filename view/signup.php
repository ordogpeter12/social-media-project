<?php
    include_once "../controller/user_controller.php";
    include_once "common_display.php";
    include_once "../config/config_variables.php";
    include_once "../dao/user_dao.php";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Regisztráció</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="right_nav"><a href="login.php" class="nav_link"><div class="nav_div"><p>Bejelentkezés</p></div></a></li>
                <li class="right_nav"><div class="nav_div" id="nav_current"><p>Regisztráció</p></div></li>
            </ul>
        </nav>
    </header>
    <form action="#" method="POST">
        <fieldset class="user_info">
            <legend>Regisztráció</legend>
            <label>Felhasználónév: <input type="text" name="name" required></label>
            <br>
            <label>Email: <input type="email" name="email" required></label>
            <br>
            <label>Születési idő: <input type="text" name="birth_date" placeholder="éééé-hh-nn" required></label>
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