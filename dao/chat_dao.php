<?php
include_once "dao_base.php";
include_once "../model/chat_info.php";
include_once "../model/whole_chat.php";
include_once "../model/message.php";
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
    public function get_messages(string $current_email, string $other_name) : Chat|null
    {
        $query = "SELECT friend.nev, friend.profil_kep_utvonal, uzik.tartalom,
                  CASE
                      WHEN uzik.email = :email THEN 1
                      ELSE 0
                  END AS kuldo_e FROM (SELECT * FROM Felhasznalo WHERE nev=:name) friend
                  JOIN Uzenet uzik
                  ON (friend.email=uzik.email OR friend.email=uzik.cimzett)
                  WHERE uzik.email = :email OR uzik.cimzett = :email
                  ORDER BY uzik.ido DESC";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $current_email);
        oci_bind_by_name($statement, ":name", $other_name);
        oci_execute($statement);
        $name = "";
        $img_path = "";
        $message_array = [];
        if($first_record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $name = $first_record["NEV"];
            $img_path = $first_record["PROFIL_KEP_UTVONAL"];
            $message_array[] = new Message($first_record["TARTALOM"], $first_record["KULDO_E"]);
        }
        while($record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $message_array[] = new Message($record["TARTALOM"], $record["KULDO_E"]);
        }
        $returnable = $name !== "" ? new Chat($name, $img_path, $message_array): null;
        oci_free_statement($statement);
        return $returnable;
    }
}
