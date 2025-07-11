<?php
class Display
{
    static function print_errors(array $error_messages) : void
    {
        for($i = 0; $i < count($error_messages); $i++)
        {
            echo '<p class="error_message">'.$error_messages[$i].'</p>';
        }
    }
    /** * @param array $recommendations Egy tömb Friend objectekből
        * @param string $current_file_path A jelenlegi fájlnak az elérési útvonala project roothoz képest
    */
    static function list_friends_friend_as_html(array $recommendations, string $current_file_name, string|null $search) : void
    {
        if($recommendations !== [])
            echo "<h1>Neked ajánlottak</h1>";
        for($i = 0; $i < count($recommendations); $i++)
        {
            echo self::recommendation_card($recommendations[$i], $current_file_name, $search);
        }
    }
    static function list_friend_requests_as_html(array $requests, string $current_file_name, string|null $search) : void
    {
        if($requests !== [])
            echo "<h1>Ismerős jelölések</h1>";
        for($i = 0; $i < count($requests); $i++)
        {
            echo self::request_card($requests[$i], $current_file_name, $search);
        }
    }
    static function request_card($friend, string $current_file_name, string|null $search_value) : string
    {
        return "<div class='friend_recommendation_card'>
            <img class='recommended_user_img' src='".$friend->get_profile_img_path()."'alt='profilkép' height='100px' width='100px'>
                <div>
                    <p class='recommended_user_name'>".$friend->get_name(). "</p>
                    <div class='btn_div_row'>
                        <input class='accept_request_btn' type='button' 
                        onclick=\"location.href='".$current_file_name."?accept=".$friend->get_name().
                        ($search_value !== null ? "&search=".$search_value: "") ."'\" value='Visszaigazolas'>
                        <input class='decline_request_btn' type='button' 
                        onclick=\"location.href='".$current_file_name."?decline=".$friend->get_name().
                        ($search_value !== null ? "&search=".$search_value: "") ."'\" value='Visszautasít'>
                    </div>
                </div>
            </div>";
    }
    static function recommendation_card($friend, string $current_file_name, string|null $search_value) : string
    {
        return "<div class='friend_recommendation_card'>
        <img class='recommended_user_img' src='".$friend->get_profile_img_path()."'alt='profilkép' height='100px' width='100px'>
            <div>
                <p class='recommended_user_name'>".$friend->get_name(). "</p>
                <input class='recommended_user_btn' type='button' 
                onclick=\"location.href='".$current_file_name."?request=".$friend->get_name().
                ($search_value !== null ? "&search=".$search_value: "") ."'\" value='Jelölés'>
            </div>
        </div>";
    }
    static function friend_card($friend, string $current_file_name, string|null $search_value) : string
    {
        return "<div class='friend_recommendation_card'>
        <img class='recommended_user_img' src='".$friend->get_profile_img_path()."'alt='profilkép' height='100px' width='100px'>
            <div>
                <p class='recommended_user_name'>".$friend->get_name(). "</p>
                <input class='decline_request_btn' type='button' 
                onclick=\"location.href='".$current_file_name."?delete=".$friend->get_name().
                ($search_value !== null ? "&search=".$search_value: "") ."'\" value='Ismerős törlése'>
            </div>
        </div>";
    }
    static function requested_card($friend, string $current_file_name, string|null $search_value) : string
    {
        return "<div class='friend_recommendation_card'>
        <img class='recommended_user_img' src='".$friend->get_profile_img_path()."'alt='profilkép' height='100px' width='100px'>
            <div>
                <p class='recommended_user_name'>".$friend->get_name(). "</p>
                <input class='accept_request_btn' type='button' 
                onclick=\"location.href='".$current_file_name."?derequest=".$friend->get_name().
                ($search_value !== null ? "&search=".$search_value: "") ."'\" value='Jelölés visszavonása'>
            </div>
        </div>";
    }
    static function list_search_results(array $friend_array, string $current_file_name, string|null $search) : void
    {
        for($i = 0; $i < count($friend_array); $i++)
        {
            if($friend_array[$i]->get_friend_status() === 'a')
            {
                echo self::friend_card($friend_array[$i], $current_file_name, $search);
            }
            else if($friend_array[$i]->get_friend_status() === 'r')
            {
                echo self::request_card($friend_array[$i], $current_file_name, $search);
            }
            else if($friend_array[$i]->get_friend_status() === 'p')
            {
                echo self::requested_card($friend_array[$i], $current_file_name, $search);
            }
            else if($friend_array[$i]->get_friend_status() === 's')
            {
                echo self::recommendation_card($friend_array[$i], $current_file_name, $search);
            }
        }
    }
    static function existing_chats(array $chats) : void
    {
        for($i = 0; $i < count($chats); $i++)
        {
            echo "<a href='chat.php?user=".$chats[$i]->get_name()."' class='chat_anchor'>
                <img src='".$chats[$i]->get_profile_img_path()."' alt='Profil kép' height='70px' width='70px'>
                <div class='last_message_name_wrapper'>
                    <div class='messages_name'>".$chats[$i]->get_name()."</div>
                    <div class='messages_last_message'>".$chats[$i]->get_last_message()."</div>
                </div>
            </a>";
        }
    }
    static function display_chat_bubbles(Chat $chat) : void
    {
        $other_sended_prev_message = false;
        $messages = $chat->get_messages();
        for($i = 0; $i < count($messages); $i++)
        {
            if($messages[$i]->is_sender())
            {
                self::print_own_bubble($messages[$i]->get_content());
                $other_sended_prev_message = false;
            }
            else
            {
                self::print_others_bubble($messages[$i]->get_content(),
                $other_sended_prev_message ? "": $chat->get_profile_img_path());
                $other_sended_prev_message = true;
            }
        }
    }
    static function print_own_bubble(string $message) : void
    {
        echo "<div class='general_message_bubble own_message_bubble'>".
        $message."</div>";
    }
    static function print_others_bubble(string $message, string $img_path) : void
    {
        echo "<div class='img_bubble_wrapper'>".
            ($img_path === "" ? "<div class='chat_img'></div>": "<img src='".$img_path."' alt='Profil kép' class='chat_img'>")
            ."<div class='general_message_bubble other_message_bubble'>".
            $message."</div></div>";
    }
}

?>