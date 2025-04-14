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
    static function list_friends_friend_as_html(array $recommendations, string $current_file_name) : void
    {
        echo "<div class='friend_recommendation_scroll_view'>
        <h1>Neked ajánlottak</h1>";
        for($i = 0; $i < count($recommendations); $i++)
        {
            echo "<div class='friend_recommendation_card'>
            <img class='recommended_user_img' src='".$recommendations[$i]->get_profile_img_path()."'alt='profilkép' height='100px' width='100px'>
                <div>
                    <p class='recommended_user_name'>".$recommendations[$i]->get_name(). "</p>
                    <input class='recommended_user_btn' type='button' 
                    onclick=\"location.href='".$current_file_name."?request=".$recommendations[$i]->get_name()."'\" value='Jelölés'>
                </div>
            </div>";
        }
        echo "</div>";
    }
}

?>