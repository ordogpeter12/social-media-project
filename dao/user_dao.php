<?php
include_once "dao_base.php";
class UserDao extends DaoBase
{
    private static $instance;
    private function UserDao()
    {
        parent::__construct();
    }
    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }
    public function test_function()
    {
        DaoBase::get_connection();
    }
    
}

?>