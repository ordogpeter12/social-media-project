<?php
    include_once "common_display.php";
    include_once "../controller/friend_controller.php";
    include_once "../model/user.php";
    session_start();
    if(!array_key_exists("user", $_SESSION)) { header("Location: login.php"); die; }
    if(isset($_GET["request"]))
    {
        FriendController::get_instance()->friend_request($_SESSION["user"]->get_email(), $_GET["request"]);
    }
    else if(isset($_GET["accept"]))
    {
        FriendController::get_instance()->accept_friend_request($_SESSION["user"]->get_email(), $_GET["accept"]);
    }
    else if(isset($_GET["decline"]))
    {
        FriendController::get_instance()->decline_friend_request($_SESSION["user"]->get_email(), $_GET["decline"]);
    }
    else if(isset($_GET["derequest"]))
    {
        FriendController::get_instance()->derequest_friend_request($_SESSION["user"]->get_email(), $_GET["derequest"]);
    }
    else if(isset($_GET["delete"]))
    {
        FriendController::get_instance()->delete_friend($_SESSION["user"]->get_email(), $_GET["delete"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Ismerősök keresése</title>
</head>
<body>
    <header>
        <nav>
            <ul>
            <li class="left_nav"><div class="nav_div" id="nav_current"><p>Ismerősök keresése</p></div></li>
            <li class="left_nav"><a href="conversations.php" class="nav_link"><div class="nav_div"><p>Beszélgetések</p></div></a></li>
            <li class="right_nav"><a href="profile.php" class="nav_link"><div class="nav_div"><p>Profil</p></div></a></li>
            <?php
                if($_SESSION["user"]->get_role() === 'a')
                    echo '<li class="right_nav"><a href="admin.php" class="nav_link"><div class="nav_div"><p>Admin</p></div></a></li>';
            ?>
            </ul>
        </nav>
    </header>
    <form action="#" method="GET" id="search_form">
        <input type="text" id="search_bar" placeholder="Keresés" name="search">
        <input type="submit" id="search_btn" value="Kereses" name="search_btn">
    </form>
    <div id="main_recommendation">
        <div class='friend_recommendation_scroll_view'>
        <?php
            Display::list_friend_requests_as_html(
                FriendController::get_instance()->get_friend_requests($_SESSION["user"]->get_email()), $_SERVER["SCRIPT_NAME"], $_GET["search"] ?? null);
            Display::list_friends_friend_as_html(
                FriendController::get_instance()->get_friends_friends($_SESSION["user"]->get_email()), $_SERVER["SCRIPT_NAME"], $_GET["search"] ?? null);
        ?>
        </div>
        <div class="friend_recommendation_scroll_view">
            <h1>Kersesési találatok</h1>
            <?php
                if(isset($_GET["search"]))
                {
                    Display::list_search_results(
                        FriendController::get_instance()->get_search_results_with_friend_status($_SESSION["user"]->get_email(), $_GET["search"]),
                        $_SERVER["SCRIPT_NAME"], $_GET["search"] ?? null);
                }
            ?>
        </div>
    </div>
</body>
</html>