<?php
include_once "../model/user.php";
include_once "../controller/admin_controller.php";
include_once "common_display.php";
session_start();
if(!array_key_exists("user", $_SESSION) || $_SESSION["user"]->get_role() !== "a") { header("Location: ../index.php"); die; }
if(isset($_GET["word"]))
{
    $error_messages = AdminController::get_instance()->add_disallowed_word($_GET["word"]);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Admin</title>
</head>
<body>
<header>
        <nav>
            <ul>
            <li class="left_nav"><a href="search_friends.php" class="nav_link"><div class="nav_div"><p>Ismerősök keresése</p></div></a></li>
            <li class="right_nav"><a href="profile.php" class="nav_link"><div class="nav_div"><p>Profil</p></div></a></li>
            <li class="right_nav"><div class="nav_div" id="nav_current"><p>Admin</p></div></li>
            </ul>
        </nav>
    </header>
    <form action="#" method="GET">
        <fieldset class="user_info">
            <legend>Tiltott szó felvétele</legend>
            <label>Szó: <input type="text" name="word" required></label>
            <br>
            <?php
                if(isset($error_messages))
                {
                    Display::print_errors($error_messages);
                }
            ?>
            <input type="submit" value="Felvétel" name="disallowed_word">
        </fieldset>
    </form>
</body>
</html>