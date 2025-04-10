<?php
    include_once "../dao/user_dao.php";
    include_once "../model/user.php";
    class UserController
    {
        private static UserController $instance;

        /*Returns an array of strings with the type of errors. Errors can be given directly to users.*/
        public static function get_instance()
        {
            if(!isset(self::$instance))
            {
                self::$instance = new UserController();
            }
            return self::$instance;
        }
        public function signup($username, $email, $birth_date, $password, $password_again) : array
        {
            $error_messages = [];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { $error_messages[] = "Give a valid email!"; }
            if(!empty(UserDao::get_instance()->get_user_by_email($email))) { $error_messages[] = "The email is already associated with an account!"; }
            if(empty($username) || trim($username) === "") { $error_messages[] = "Give a username!"; }
            if(!empty(UserDao::get_instance()->get_user_by_name($username))) { $error_messages[] = "This username is occupied!"; }
            if(empty($password) || trim($password) === "") { $error_messages[] = "Give a password!"; }
            if($password !== $password_again) { $error_messages[] = "The two password does not match!"; }
            if(!$this->validate_date($birth_date)) { $error_messages[] = "The date should have 'yyyy-mm-dd' format"; }
            if(count($error_messages) === 0)
            {
                if(!UserDao::get_instance()->signup(new User($username, $email, password_hash($password, PASSWORD_DEFAULT), "u", new DateTime($birth_date))))
                {
                    $error_messages[] = "Registration failed for unknown reasons. Try again!";
                }
            }
            return $error_messages;
        }
        private function validate_date($date_string) : bool
        {
            if($date_string === null || strlen($date_string) !== strlen("yyyy-mm-dd")) { return false; }
            for($i = 0; $i < strlen($date_string); $i++)
            {
                if($i != 4 && $i != 7)
                {
                    if(!$this->isdigit($date_string[$i]))
                    {
                        return false;
                    }
                }
                else
                {
                    if($date_string[$i] !== "-")
                    {
                        return false;
                    }
                }
            }
            $date_array = explode("-", $date_string);
            return checkdate($date_array[1], $date_array[2], $date_array[0]);
        }
        private function isdigit($char) : bool
        {
            switch($char)
            {
            case "0": case "1": case "2": case "3": case "4":
            case "5": case "6": case "7": case "8": case "9":
                return true;
            default:
                return false;
            }
        }
    }

?>