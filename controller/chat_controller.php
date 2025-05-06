<?php
include_once "../dao/chat_dao.php";
include_once "../model/chat_info.php";
include_once "../model/whole_chat.php";
include_once "../model/message.php";
include_once "../dao/friend_dao.php";
class ChatController
{
    private static ChatController $instance;

    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new ChatController();
        }
        return self::$instance;
    }

    public function get_existing_chats(string $current_email) : array
    {
        return ChatDao::get_instance()->get_existing_chats($current_email);
    }
    public function get_messages($current_email, $other_username) : Chat|null
    {
        if($other_username !== null && $other_username !== "")
        {
            return ChatDao::get_instance()->get_messages($current_email, $other_username);
        }
        return null;
    }
    public function send_message($current_email, $name, $content) : array
    {
        $error_masseges = [];
        if($name !== null || $name != "" || $content !== null || trim($content) !== "")
        {
            if(strlen($content) <= 1024)
            {
                $other_user_email = FriendDao::get_instance()->are_friends($current_email, $name);
                if($other_user_email !== null)
                {
                    ChatDao::get_instance()->send_message($current_email, $other_user_email, $content);
                }
                else
                {
                    $error_masseges[] = "Nem küldhetsz üzenetet ennek a felhasznalónak!";
                }
            }
            else
            {
                $error_masseges[] = "Az üzenet maximum 1024 karakter hosszú lehet";
            }
        }
        return $error_masseges;
    }
}