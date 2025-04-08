<?php
include_once "dao_base.php";
class UserDao extends DaoBase
{
    private static $instance;
    private function UserDao() {}
    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }
    
}

?>