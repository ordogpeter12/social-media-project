<?php
include_once "../dao/friend_dao.php";
include_once "../model/friend.php";
include_once "../dao/user_dao.php";
    class FriendController
    {
        private static FriendController $instance;

        public static function get_instance()
        {
            if(!isset(self::$instance))
            {
                self::$instance = new FriendController();
            }
            return self::$instance;
        }
        public function get_friends_friends(string $email) : array
        {
            $possible_friends = FriendDao::get_instance()->get_friends_friends($email);
            return $possible_friends;
        }
        public function friend_request(string $current_user, $name) : void
        {
            if($user = UserDao::get_instance()->get_user_by_name($name))
            {
                FriendDao::get_instance()->friend_request($current_user, $user->get_email());
            }
        }
    }