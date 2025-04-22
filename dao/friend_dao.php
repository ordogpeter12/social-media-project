<?php
include_once "dao_base.php";
include_once "../model/friend.php";
include_once "../model/chat_info.php";
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
    public function get_friend_requests(string $email) : array
    {
        $query = "SELECT felhasznalo.nev, felhasznalo.profil_kep_utvonal
                  FROM Ismeretseg pending
                  JOIN Felhasznalo felhasznalo ON felhasznalo.email = pending.email1
                  WHERE pending.email2 = :email
                  AND pending.allapot = 'p'";
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
    public function is_friendable_and_get_email(string $current_user_email, string $name) : string|null
    {
        $query = "SELECT invitalt.email
                  FROM Felhasznalo invitalt
                  WHERE invitalt.nev = :invited_name
                  AND NOT EXISTS (
                  SELECT 1 FROM Ismeretseg invitalo_ismerosok
                  WHERE (invitalo_ismerosok.email1 = invitalt.email AND invitalo_ismerosok.email2 = :current_user_email)
                  OR (invitalo_ismerosok.email2 = invitalt.email AND invitalo_ismerosok.email1 = :current_user_email))";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":invited_name", $name);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        $returnable = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS);
        oci_free_statement($statement);
        return $returnable["EMAIL"];
    }
    public function is_acceptable_and_get_email(string $current_user_email, string $name) : string|null
    {
        $query = "SELECT elfogatott.email
                  FROM Felhasznalo elfogatott
                  WHERE elfogatott.nev = :invited_name
                  AND EXISTS (
                  SELECT 1 FROM Ismeretseg elfogado_ismerosok
                  WHERE elfogado_ismerosok.email1 = elfogatott.email
                  AND elfogado_ismerosok.email2 = :current_user_email
                  AND elfogado_ismerosok.allapot = 'p')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":invited_name", $name);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        $returnable = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS);
        oci_free_statement($statement);
        return $returnable["EMAIL"] ?? $returnable;
    }
    public function accept_request(string $current_user_email, string $accepted_user_email) : void
    {
        $query = "UPDATE Ismeretseg SET allapot='a' 
                  WHERE email1=:accepted_email AND email2=:current_user_email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":accepted_email", $accepted_user_email);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        oci_free_statement($statement);
    }
    public function is_declineable_and_get_email(string $current_user_email, string $name) : string|null
    {
        $query = "SELECT visszautasitott.email
                  FROM Felhasznalo visszautasitott
                  WHERE visszautasitott.nev = :declined_name
                  AND EXISTS (
                  SELECT 1 FROM Ismeretseg visszautasito_ismerosok
                  WHERE visszautasito_ismerosok.email1 = visszautasitott.email
                  AND visszautasito_ismerosok.email2 = :current_user_email
                  AND visszautasito_ismerosok.allapot = 'p')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":declined_name", $name);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        $returnable = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS);
        oci_free_statement($statement);
        return $returnable["EMAIL"] ?? $returnable;
    }
    public function is_derequestable_and_get_email(string $current_user_email, string $name) : string|null
    {
        $query = "SELECT visszavaonando.email
                  FROM Felhasznalo visszavaonando
                  WHERE visszavaonando.nev = :declined_name
                  AND EXISTS (
                  SELECT 1 FROM Ismeretseg visszavono_ismerosok
                  WHERE visszavono_ismerosok.email2 = visszavaonando.email
                  AND visszavono_ismerosok.email1 = :current_user_email
                  AND visszavono_ismerosok.allapot = 'p')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":declined_name", $name);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        $returnable = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS);
        oci_free_statement($statement);
        return $returnable["EMAIL"] ?? $returnable;
    }
    public function is_deleteable_and_get_email(string $current_user_email, string $name) : string|null
    {
        $query = "SELECT torlendo.email
                  FROM Felhasznalo torlendo
                  WHERE torlendo.nev = :deleted_name
                  AND EXISTS (
                  SELECT 1 FROM Ismeretseg torlo
                  WHERE ((torlo.email2 = torlendo.email AND torlo.email1 = :current_user_email)
                  OR (torlo.email1 = torlendo.email AND torlo.email2 = :current_user_email))
                  AND torlo.allapot = 'a')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":deleted_name", $name);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        $returnable = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS);
        oci_free_statement($statement);
        return $returnable["EMAIL"] ?? $returnable;
    }
    public function decline_friend_request(string $current_user_email, string $declined_user_email) : void
    {
        $query = "DELETE FROM Ismeretseg
                  WHERE email1=:ddeclinable_email AND email2=:current_user_email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":ddeclinable_email", $declined_user_email);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        oci_free_statement($statement);
    }
    public function derequest_friend(string $current_user_email, string $derequested_user_email) : void
    {
        $query = "DELETE FROM Ismeretseg
                  WHERE email2=:deleteable_email AND email1=:current_user_email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":deleteable_email", $derequested_user_email);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        oci_free_statement($statement);
    }
    public function delete_friend(string $current_user_email, string $deleted_user_email) : void
    {
        $query = "DELETE FROM Ismeretseg
                  WHERE (email2=:deletable_email AND email1=:current_user_email)
                  OR (email1=:deletable_email AND email2=:current_user_email)";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":deletable_email", $deleted_user_email);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_execute($statement);
        oci_free_statement($statement);
    }
    //null az ismerősi állapot, ha teljesen idegenek
    public function get_search_results_with_status(string $current_user_email, string $substr) : array
    {
        $query = "SELECT felhasznalok.nev, felhasznalok.profil_kep_utvonal, 
                  CASE 
                      WHEN ismerosok.email2 = :current_user_email AND ismerosok.allapot = 'p' THEN 'r'
                      ELSE ismerosok.allapot
                  END AS allapot FROM Felhasznalo felhasznalok
                  LEFT JOIN Ismeretseg ismerosok
                  ON ((ismerosok.email1 = :current_user_email AND ismerosok.email2 = felhasznalok.email)
                  OR (ismerosok.email2 = :current_user_email AND ismerosok.email1 = felhasznalok.email))
                  WHERE felhasznalok.email != :current_user_email
                  AND LOWER(felhasznalok.nev) LIKE LOWER('%' || :substr || '%')";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":current_user_email", $current_user_email);
        oci_bind_by_name($statement, ":substr", $substr);
        oci_execute($statement);
        $returnable_friend_array = [];
        while($record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $returnable_friend_array[] = new Friend($record["NEV"], $record["PROFIL_KEP_UTVONAL"], $record["ALLAPOT"]);
        }
        oci_free_statement($statement);
        return $returnable_friend_array;
    }
    public function are_friends(string $current_email, string $other_name) : string|null
    {
        $query = "SELECT felhasznalo.email FROM
                  (SELECT * FROM felhasznalo WHERE nev=:name) felhasznalo
                  JOIN ismeretseg ismereteseg 
                  ON (ismereteseg.email1 = felhasznalo.email OR ismereteseg.email2 = felhasznalo.email)
                  WHERE (ismereteseg.email1 = :email OR ismereteseg.email2 = :email)
                  AND ismereteseg.allapot='a'";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $current_email);
        oci_bind_by_name($statement, ":name", $other_name);
        oci_execute($statement);
        $returnable = null;
        if($user = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
            $returnable = $user["EMAIL"];
        oci_free_statement($statement);
        return $returnable;
    }
    public function get_searched_friends(string $current_user_email, string $substr) : array
    {
        $query = "SELECT felhasznalok.nev, felhasznalok.profil_kep_utvonal
                  FROM (SELECT * FROM ismeretseg
                  WHERE (email1=:email OR email2=:email) AND allapot='a') ismerosok
                  JOIN (SELECT nev, email, profil_kep_utvonal FROM felhasznalo 
                  WHERE email<>:email AND LOWER(nev) LIKE LOWER('%' || :substr || '%')) felhasznalok
                  ON (ismerosok.email1=felhasznalok.email OR ismerosok.email2=felhasznalok.email)
                  ORDER BY felhasznalok.nev";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $current_user_email);
        oci_bind_by_name($statement, ":substr", $substr);
        oci_execute($statement);
        $returnable_chat_array = [];
        while($record = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            $returnable_chat_array[] = new ChatInfo($record["NEV"], $record["PROFIL_KEP_UTVONAL"]);
        }
        oci_free_statement($statement);
        return $returnable_chat_array;
    }
}