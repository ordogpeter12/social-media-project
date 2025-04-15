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
            if($name !== null && $invited_email = FriendDao::get_instance()->is_friendable_and_get_email($current_user, $name))
            {
                FriendDao::get_instance()->friend_request($current_user, $invited_email);
            }
        }
        public function get_friend_requests(string $current_user_email) : array
        {
            return FriendDao::get_instance()->get_friend_requests($current_user_email);
        }
        public function accept_friend_request(string $current_user_email, $accepted_username) : void
        {
            if($accepted_username !== null && $accepted_email = FriendDao::get_instance()->is_acceptable_and_get_email($current_user_email, $accepted_username))
            {
                FriendDao::get_instance()->accept_request($current_user_email, $accepted_email);
            }
        }
        public function decline_friend_request(string $current_user_email, $declined_username) : void
        {
            if($declined_username !== null && $declined_email = FriendDao::get_instance()->is_declineable_and_get_email($current_user_email, $declined_username))
            {
                FriendDao::get_instance()->delete_friend($current_user_email, $declined_email);
            }
        }
    }