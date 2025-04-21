<?php
include_once "../dao/chat_dao.php";
include_once "../model/chat_info.php";
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
}