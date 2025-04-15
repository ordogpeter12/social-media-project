<?php
    session_start();
    include_once "common_display.php";
    include_once "../dao/user_dao.php";
    include_once "../controller/user_controller.php";
    include_once "../dao/friend_dao.php";
    FriendDao::get_instance()->get_friends_friends("legobatman2@gmail.com");
    if(array_key_exists("user", $_SESSION)) { header("Location: profile.php"); die; }
    if(isset($_POST["login"]))
    {
        /*Sikeres bejelentkezés esetnén a $_SESSION tömben "user" kulccsal elérhető
        a bejelentkezett felhasználó User object-je*/
        $error_messages = UserController::get_instance()->login($_POST["email"], $_POST["password"]);
        if(!count($error_messages)) { header("Location: profile.php"); die; }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Bejelentkezés</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="right_nav"><div class="nav_div" id="nav_current"><p>Bejelentkezés</p></div></li>
                <li class="right_nav"><a href="signup.php" class="nav_link"><div class="nav_div"><p>Regisztráció</p></div></a></li>
            </ul>
        </nav>
    </header>
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