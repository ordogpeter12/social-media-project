<?php
    include_once "common_display.php";
    include_once "../model/user.php";
    include_once "../model/whole_chat.php";
    include_once "../model/message.php";
    include_once "../controller/chat_controller.php";
    session_start();
    if(!array_key_exists("user", $_SESSION)) { header("Location: login.php"); die; }
    if(isset($_POST["send"]) && isset($_POST["new_message"]) && isset($_GET["user"]))
    {
        $error_masseges = ChatController::get_instance()->send_message($_SESSION["user"]->get_email(), $_GET["user"], $_POST["new_message"]);
    }
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
        <?php
            if(isset($_GET["user"]) && $chat = ChatController::get_instance()->get_messages($_SESSION["user"]->get_email(), $_GET["user"]))
            {
                Display::display_chat_bubbles($chat);
            }
        ?>
    </div>
    <form action="#" method="POST" id="chat_form">
        <input type="text" name="new_message" id="message_input" autocomplete="off" 
        <?php
            if(isset($error_masseges))
            {
                echo "placeholder=\"".$error_masseges[0]."\"";
            }
        ?>>
        <input type="submit" id="send_btn" value="Küldés" name="send">
    </form>
</body>
</html>