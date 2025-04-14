<?php
    include_once "common_display.php";
    include_once "../controller/friend_controller.php";
    include_once "../model/user.php";
    session_start();
    if(!array_key_exists("user", $_SESSION)) { header("Location: ../index.php"); }
    if(isset($_GET["request"]))
    {
        FriendController::get_instance()->friend_request($_SESSION["user"]->get_email(), $_GET["request"]);
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
            <li class="right_nav"><a href="profile.php" class="nav_link"><div class="nav_div"><p>Profil</p></div></a></li>
            </ul>
        </nav>
    </header>
    <form action="#" method="GET" id="search_form">
        <input type="text" id="search_bar" placeholder="Keresés" name="searches_string">
        <input type="submit" id="search_btn" value="Kereses" name="search">
    </form>
    <div id="main_recommendation">
        <?php
            Display::list_friends_friend_as_html(
                FriendController::get_instance()->get_friends_friends($_SESSION["user"]->get_email()), $_SERVER["SCRIPT_NAME"]);
        ?>
        <div class="friend_recommendation_scroll_view">
            <h1>Kersesési találatok</h1>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="button" onclick="location.href='search_friends.php?user=a'" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">fsdf</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div class="recommended_user_btn_name_container">
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div>
                    <p class="recommended_user_name">fsdf</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
            <div class="friend_recommendation_card">
                <img class="recommended_user_img" src="../assets/tmp.png" alt="profilkép" height="100px" width="100px">
                <div class="recommended_user_btn_name_container">
                    <p class="recommended_user_name">Ezegynagyonjónévlehethaúgyakarom</p>
                    <input class="recommended_user_btn" type="submit" value="Jelölés">
                </div>
            </div>
        </div>
    </div>
</body>
</html>