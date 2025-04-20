<?php
    include_once "../model/user.php";
    include_once "../controller/user_controller.php";
    include_once "common_display.php";
    session_start();
    if(!array_key_exists("user", $_SESSION)) { header("Location: login.php"); die; }
    if(isset($_POST["change"]))
    {
        $error_messages = UserController::get_instance()->update_user($_SESSION["user"], $_POST["email"], $_POST["name"], $_POST["birth_date"], $_POST["password"], $_POST["password_again"], $_POST["old_password"]);
    }
    if(isset($_POST["delete_profile"]))
    {
        $error_messages = UserController::get_instance()->delete_user($_POST["email"], $_POST["name"], $_POST["birth_date"], $_POST["password"], $_SESSION["user"]->get_email(), $_POST["old_password"]);
    }
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/style.css" rel="stylesheet">
        <title>Profil</title>
    </head>
<body>
    <header>
        <nav>
            <ul>
                <li class="left_nav"><a href="search_friends.php" class="nav_link"><div class="nav_div"><p>Ismerősök keresése</p></div></a></li>
                <li class="right_nav"><div class="nav_div" id="nav_current"><p>Profil</p></div></li>
                <?php
                    if($_SESSION["user"]->get_role() === 'a')
                        echo '<li class="right_nav"><a href="admin.php" class="nav_link"><div class="nav_div"><p>Admin</p></div></a></li>';
                ?>
            </ul>
        </nav>
    </header>
    <form action="#" method="POST">
        <fieldset class="user_info">
            <legend>Felhasználói adatok</legend>
            <label>Felhasználónév: <input type="text" name="name" value='<?php echo $_SESSION["user"]->get_name();?>' required></label>
            <br>
            <label>Email: <input value="<?php echo $_SESSION["user"]->get_email();?>" type="email" name="email" required></label>
            <br>
            <label>Születési idő: <input value="<?php echo $_SESSION["user"]->get_birthday_as_string();?>" type="text" name="birth_date" placeholder="éééé-hh-nn" required></label>
            <br>
            <label>Új jelszó: <input type="password" name="password"></label>
            <br>
            <label>Új jelszó újra: <input type="password" name="password_again"></label>
            <br>
            <label>Jelenlegi jelszó: <input type="password" name="old_password" required></label>
            <br>
            <?php
                if(isset($error_messages))
                {
                    Display::print_errors($error_messages);
                }
            ?>  
            <input type="submit" name="change" value="Apply changes">
            <br>
            <input type="button" onclick="location.href='logout.php'" value="Logout">
            <br>
            <input class="delete_button" type="submit" name="delete_profile" value="Delete profile">
        </fieldset>
    </form>

</body>
</html>