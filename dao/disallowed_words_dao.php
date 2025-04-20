<?php
include_once "dao_base.php";
class BadWordsDao extends DaoBase
{
    private static $instance;
    private function BadWordsDao()
    {
        parent::__construct();
    }
    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new BadWordsDao();
        }
        return self::$instance;
    }
    public function add_bad_word(string $word) : bool
    {
        $query = "INSERT INTO TiltottSzavak(szo)
                  VALUES(:word)";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":word", $word);
        $returnable_bool = oci_execute($statement);
        oci_free_statement($statement);
        return $returnable_bool;
    }
}