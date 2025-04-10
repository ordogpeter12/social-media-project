<?php
include_once "../config/config_variables.php";
abstract class DaoBase
{
    private static $connection;
    private static int $reference_count = 0;
    /*Mindig meg kell hívni a gyerek osztály konstruktorában!*/
    function __construct()
    {
        self::$reference_count++;
    }
    protected function get_connection()
    {
        if(!isset(self::$connection))
        {
            $tns = "(DESCRIPTION =
                    (ADDRESS_LIST =
                    (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
                    )
                    (CONNECT_DATA =
                    (SID = orania2)
                    )
                )";
            self::$connection = oci_connect(DataBaseCredentials::$DB_USERNAME, DataBaseCredentials::$DB_PASSWORD, $tns,'UTF8');
            if(!self::$connection)
            {
                die("Couldn't connect to database!");
            }
        }
        return self::$connection;
    }
    public static abstract function get_instance();
    public function __destruct()
    {
        if(self::$reference_count === 1 && self::$connection)
        {
            oci_close(self::$connection);
        }
        self::$reference_count--;
    }
}


?>