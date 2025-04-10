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
}

?>