<?php
include_once "../config/config_variables.php";
abstract class DaoBase
{
    private static $connection;
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
        }
        return self::$connection;
    }
    public static abstract function get_instance();
    public function __destruct()
    {
        oci_close(self::$connection);
    }
}


?>