<?php
    include_once "../dao/user_dao.php";
    include_once "../model/user.php";
    class UserController
    {
        private static UserController $instance;

        /*Visszatér egy sztringeket tartalmazó tömbbel, amely a hibák típusait jelöli.
        A hibák közvetlenül megjeleníthetők a felhasználók számára.*/
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
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { $error_messages[] = "Adj meg egy érvényes email címet!"; }
            if(UserDao::get_instance()->does_username_exist($username)) { $error_messages[] = "Ez a felhasználónév már foglalt!"; }
            if(UserDao::get_instance()->does_user_email_exist($email)) { $error_messages[] = "Ez az email cím már használatban van!"; }
            if(empty($username) || trim($username) === "") { $error_messages[] = "Adj meg egy felhasználónevet!"; }//
            if(empty($password) || trim($password) === "") { $error_messages[] = "Adj meg egy jelszót!"; }
            if($password !== $password_again) { $error_messages[] = "A két jelszó nem egyezik!"; }
            if(!$this->validate_date($birth_date)) { $error_messages[] = "A dátum formátuma legyen 'éééé-hh-nn'!"; }
            if(count($error_messages) === 0)
            {
                if(!UserDao::get_instance()->signup(new User($username, $email, password_hash($password, PASSWORD_DEFAULT), "u", new DateTime($birth_date))))
                {
                    $error_messages[] = "A regisztráció ismeretlen okoból nem sikerült. Próbáld újra!";
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

        public function login(string $email, string $password) : array
        {
            $user = UserDao::get_instance()->get_user_by_email($email);
            $error_messages = [];
            if($user !== null && password_verify($password, $user->get_hashed_password()))
            {
                $_SESSION["user"] = $user;
            }
            else
            {
                $error_messages[] = "Helytelen email vagy jelszó!";
            }
            return $error_messages;
        }
        public function update_user(User $user, string $email, string $name, string $birthday, string $password, string $password_again, string $old_password) : array
        {
            $error_messages = [];
            if($user->get_email() !== $email)
            {
                if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                { $error_messages[] = "Adj meg egy érvényes email címet!"; }
                else if(UserDao::get_instance()->does_user_email_exist($email))
                { $error_messages[] = "Ez a felhasználónév már foglalt!"; }
            }
            if(empty($name) || trim($name) === "")
            { $error_messages[] = "Adj meg egy új nevet, vagy hagyd meg a régit!"; }
            else if($name !== $user->get_name())
            {
                if(UserDao::get_instance()->does_username_exist($name)) { $error_messages[] = "Ez a felhasználónév már foglalt!"; }
            }
            if(empty($password) || trim($password) === "")
            { $password = $old_password; }
            else if($password !== $password_again)
            { $error_messages[] = "Akét jelszó nem egyezik meg!"; }
            if($_SESSION["user"] === null || !password_verify($old_password, $_SESSION["user"]->get_hashed_password()))
            { $error_messages[] = "A jelenlegi jelszó helytelen!"; }
            if(!$this->validate_date($birthday)) { $error_messages[] = "A dátum formátuma legyen 'éééé-hh-nn'!"; }
            if(count($error_messages) === 0)
            {
                if(!UserDao::get_instance()->update_user($user->get_email(), $email, $name, $birthday, password_hash($password, PASSWORD_DEFAULT)))
                {
                    return ["A felhasználói adatok módosítása ismeretlen okokból nem sikerült!"];
                }
                $_SESSION["user"] = UserDao::get_instance()->get_user_by_email($email);
            }
            return $error_messages;
        }
        public function delete_user(string $email, string $name, string $birthday, string $password, string $old_email, string $old_password) : array
        {
            $error_messages = [];
            if(!password_verify($old_password, $_SESSION["user"]->get_hashed_password()))
            {
                $error_messages[] = "A jelszó helytelen!";
            }
            if($email !== $old_email || $name !== $_SESSION["user"]->get_name() || $birthday !== $_SESSION["user"]->get_birthday_as_string() || trim($password) !== "")
            {
                $error_messages[] = "Biztosan a jó gombot nyomtad meg??";
            }
            if(count($error_messages) === 0)
            {
                if(UserDao::get_instance()->delete_user($old_email))
                {
                    header("Location: logout.php");
                    die;
                }
                else
                {
                    $error_messages[] = "A profil törlése ismeretlen okokból meghiúsult!";
                }
            }
            return $error_messages;
        }
    }

?>