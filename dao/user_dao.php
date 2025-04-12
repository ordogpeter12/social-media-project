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
    public function signup(User $user) : bool
    {
        $query = "INSERT INTO Felhasznalo(nev, email, jelszo, szuletesi_datum)
                  VALUES (:name, :email, :password, TO_DATE(:birth_date, 'yyyy-mm-dd'))";
        $statement = oci_parse(parent::get_connection(), $query);
        $username = $user->get_name();
        $email = $user->get_email();
        $password = $user->get_hashed_password();
        $birthday = $user->get_birthday()->format("Y-m-d");
        oci_bind_by_name($statement, ":name", $username);
        oci_bind_by_name($statement, ":email", $email);
        oci_bind_by_name($statement, ":password", $password);
        oci_bind_by_name($statement, ":birth_date", $birthday);
        $is_success = oci_execute($statement);
        oci_free_statement($statement);
        return $is_success;
    }
    public function get_user_by_email(string $email) : User|null
    {
        $query = "SELECT email, nev, jelszo, szerepkor, 
        to_char(szuletesi_datum,'YYYY-MM-DD') as szuletesi_datum 
        FROM Felhasznalo WHERE email=:email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);
        $returnable_array = oci_fetch_array($statement, OCI_ASSOC);
        if($returnable_array === false) { $returnable_array = []; }
        oci_free_statement($statement);
        $birthday = new DateTime();
        $birthday->createFromFormat("YYYY-MM-DD", $returnable_array["SZULETESI_DATUM"]);
        return $returnable_array === [] ? null: new User($returnable_array["NEV"],
        $returnable_array["EMAIL"], $returnable_array["JELSZO"],
        $returnable_array["SZEREPKOR"], $birthday);
    }
    public function does_user_email_exist(string $email) : bool
    {
        $query = "SELECT * FROM Felhasznalo WHERE email=:email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);
        $returnable_bool = oci_fetch($statement);
        oci_free_statement($statement);
        return $returnable_bool;
    }
    public function does_username_exist(string $name) : bool
    {
        $query = "SELECT * FROM Felhasznalo WHERE nev=:name";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":name", $name);
        oci_execute($statement);
        $returnable_bool = oci_fetch($statement);
        oci_free_statement($statement);
        return $returnable_bool;
    }
    
}

?>