<?php
    include_once "common_display.php";
    include_once "../controller/friend_controller.php";
    include_once "../model/user.php";
    session_start();
    if(!array_key_exists("user", $_SESSION)) { header("Location: login.php"); die; }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Chat</title>
</head>
<body>
    <header>
        <nav>
            <ul>
            <li class="left_nav"><a href="search_friends.php" class="nav_link"><div class="nav_div"><p>Ismerősök keresése</p></div></a></li>
            <li class="left_nav"><a href="conversations.php" class="nav_link"><div class="nav_div"><p>Beszélgetések</p></div></a></li>
            <?php
                if($_SESSION["user"]->get_role() === 'a')
                    echo '<li class="right_nav"><a href="admin.php" class="nav_link"><div class="nav_div"><p>Admin</p></div></a></li>';
            ?>
            <li class="right_nav"><a href="profile.php" class="nav_link"><div class="nav_div"><p>Profil</p></div></a></li>
            </ul>
        </nav>
    </header>
    <div id="chat_field">
        <div class="general_message_buble own_message_bubble">Ez egy üzenet</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble own_message_bubble">Ez egy üzenet</div>
        <div class="general_message_buble own_message_bubble">Ez egy üzenet</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
        <div class="general_message_buble other_message_bubble">Ez is egy üzenet, de nem az enyém</div>
    </div>
    <form action="#" method="POST" id="chat_form">
        <input type="text" name="new_message" id="message_input">
        <input type="submit" id="send_btn" value="Küldés" name="send">
    </form>
</body>
</html>