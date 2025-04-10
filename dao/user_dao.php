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
    public function get_user_by_email(string $email) : array
    {
        $query = "SELECT * FROM Felhasznalo WHERE email=:email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);
        $returnable_array = oci_fetch_array($statement, OCI_ASSOC);
        if($returnable_array === false) { $returnable_array = []; }
        oci_free_statement($statement);
        return $returnable_array;
    }
    public function get_user_by_name(string $name) : array
    {
        $query = "SELECT * FROM Felhasznalo WHERE nev=:name";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":name", $name);
        oci_execute($statement);
        $returnable_array = oci_fetch_array($statement, OCI_ASSOC);
        if($returnable_array === false) { $returnable_array = []; }
        oci_free_statement($statement);
        return $returnable_array;
    }
    
}

?>