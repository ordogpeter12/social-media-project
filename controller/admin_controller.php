<?php
include_once "../dao/disallowed_words_dao.php";

class AdminController
{
    private static AdminController $instance;

        public static function get_instance()
        {
            if(!isset(self::$instance))
            {
                self::$instance = new AdminController();
            }
            return self::$instance;
        }
        public function add_disallowed_word($word, $email) : array
        {
            $error_messages = [];
            if(empty($word) || $word === "")
            {
                $error_messages[] = "Adjon meg egy szót!";
            }
            else if(strlen($word) > 255)
            {
                $error_messages[] = "A szó mérete nem lehet nagyobb 255 karakternél!";
            }
            if(count($error_messages) === 0)
            {
                if(!BadWordsDao::get_instance()->add_bad_word($word, $email))
                {
                    $error_messages[] = "Ismeretlen okból nem sikerült a művelet!";
                }
            }
            return $error_messages;
        }
}