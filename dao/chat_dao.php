<?php
include_once "dao_base.php";
include_once "../model/chat_info.php";
class ChatDao extends DaoBase
{
    private static $instance;
    private function ChatDao()
    {
        parent::__construct();
    }
    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new ChatDao();
        }
        return self::$instance;
    }
    public function get_existing_chats(string $current_email) : array
    {
        $query = "SELECT tobbiek.nev, tobbiek.profil_kep_utvonal, uzik.tartalom
                  FROM Uzenet uzik
                  JOIN (SELECT * FROM felhasznalo WHERE email <> :email) tobbiek
                  ON (uzik.email = tobbiek.email OR uzik.cimzett = tobbiek.email)
                  WHERE (uzik.email = :email OR uzik.cimzett = :email)
                  AND uzik.ido = (SELECT MAX(max_uzi.ido)  FROM Uzenet max_uzi
                      WHERE (max_uzi.email = tobbiek.email OR max_uzi.cimzett = tobbiek.email))
                  ORDER BY uzik.ido DESC";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $current_email);
        oci_execute($statement);
        $returnable_chat_array = [];
        while($record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $returnable_chat_array[] = new ChatInfo($record["NEV"], $record["PROFIL_KEP_UTVONAL"], $record["TARTALOM"]);
        }
        oci_free_statement($statement);
        return $returnable_chat_array;
    }
}
