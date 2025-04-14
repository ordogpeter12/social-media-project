<?php
include_once "dao_base.php";
include_once "../model/friend.php";
class FriendDao extends DaoBase
{
    private static $instance;
    private function FriendDao()
    {
        parent::__construct();
    }
    public static function get_instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new FriendDao();
        }
        return self::$instance;
    }
    //friend array
    public function get_friends_friends(string $email) : array
    {
        $query = "SELECT cel_felhasznalok.nev,  osszes_felhasznalo.profil_kep_utvonal
                  FROM TABLE(ismerosok_ismerosei(:email)) cel_felhasznalok
                  JOIN Felhasznalo osszes_felhasznalo
                  ON cel_felhasznalok.email = osszes_felhasznalo.email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);
        $returnable_friend_array = [];
        while($record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $returnable_friend_array[] = new Friend($record["NEV"], $record["PROFIL_KEP_UTVONAL"]);
        }
        oci_free_statement($statement);
        return $returnable_friend_array;
    }
    public function friend_request(string $current_user_email, string $other_user_email) : void
    {
        $query = "INSERT INTO Ismeretseg(email1, email2, allapot)
                  VALUES(:current_user_email, :other_user, 'p')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_bind_by_name($statement, ":other_user", $other_user_email);
        oci_execute($statement);
        oci_free_statement($statement);
    }

}