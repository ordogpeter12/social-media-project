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
    static function list_search_results(array $friend_array, string $current_file_name, string|null $search) : void
    {
        for($i = 0; $i < count($friend_array); $i++)
        {
            if($friend_array[$i]->get_friend_status() === 'a')
            {
                echo self::friend_card($friend_array[$i], $current_file_name, $search);
            }
            else if($friend_array[$i]->get_friend_status() === 'p')
            {
                echo self::request_card($friend_array[$i], $current_file_name, $search);
            }
            else
            {
                echo self::recommendation_card($friend_array[$i], $current_file_name, $search);
            }
        }
    }
}

?>