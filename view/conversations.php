<?php
include_once "../model/user.php";
include_once "../model/chat_info.php";
include_once "common_display.php";
include_once "../controller/chat_controller.php";
include_once "../controller/friend_controller.php";
session_start();
if(!array_key_exists("user", $_SESSION)) { header("Location: login.php"); die; }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Üzenetek</title>
</head>
<body>
    <header>
        <nav>
            <ul>
            <li class="left_nav"><a href="search_friends.php" class="nav_link"><div class="nav_div"><p>Ismerősök keresése</p></div></a></li>
            <li class="left_nav"><div class="nav_div" id="nav_current"><p>Beszélgetések</p></div></li>
            <li class="right_nav"><a href="profile.php" class="nav_link"><div class="nav_div"><p>Profil</p></div></a></li>
            <?php
                if($_SESSION["user"]->get_role() === 'a')
                    echo '<li class="right_nav"><a href="admin.php" class="nav_link"><div class="nav_div"><p>Admin</p></div></a></li>';
            ?>
            </ul>
        </nav>
    </header>
    <form action="#" method="GET" id="search_form">
        <input type="text" id="search_bar" placeholder="Ismerősök közti keresés" name="search">
        <input type="submit" id="search_btn" value="Kereses" name="search_btn">
    </form>
    <?php
        if(isset($_GET["search"]))
        {
            Display::existing_chats(FriendController::get_instance()->search_accepted_friends($_SESSION["user"]->get_email(), $_GET["search"]));
        }
        else
        {
            Display::existing_chats(ChatController::get_instance()->get_existing_chats($_SESSION["user"]->get_email()));
        }
    ?>
    
</html>