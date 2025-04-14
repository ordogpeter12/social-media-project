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
        $query = "INSERT INTO Felhasznalo(nev, email, jelszo, szuletesi_datum, profil_kep_utvonal)
                  VALUES (:name, :email, :password, TO_DATE(:birth_date, 'yyyy-mm-dd'), :img_path)";
        $statement = oci_parse(parent::get_connection(), $query);
        $username = $user->get_name();
        $email = $user->get_email();
        $password = $user->get_hashed_password();
        $birthday = $user->get_birthday()->format("Y-m-d");
        oci_bind_by_name($statement, ":name", $username);
        oci_bind_by_name($statement, ":email", $email);
        oci_bind_by_name($statement, ":password", $password);
        oci_bind_by_name($statement, ":birth_date", $birthday);
        oci_bind_by_name($statement, "img_path", $user->get_profile_img_path());
        $is_success = oci_execute($statement);
        oci_free_statement($statement);
        return $is_success;
    }
    public function get_user_by_email(string $email) : User|null
    {
        $query = "SELECT email, nev, jelszo, szerepkor, profil_kep_utvonal, 
        to_char(szuletesi_datum,'YYYY-MM-DD') as szuletesi_datum 
        FROM Felhasznalo WHERE email=:email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_execute($statement);
        $returnable_array = oci_fetch_array($statement, OCI_ASSOC);
        if($returnable_array === false) 
        {
            oci_free_statement($statement);
            return null;
        }
        oci_free_statement($statement);
        $birthday = new DateTime();
        $birthday = $birthday->createFromFormat("Y-m-d", $returnable_array["SZULETESI_DATUM"]);
        return new User($returnable_array["NEV"],
        $returnable_array["EMAIL"], $returnable_array["JELSZO"],
        $returnable_array["SZEREPKOR"], $birthday, $returnable_array["PROFIL_KEP_UTVONAL"]);
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
    public function delete_user(string $email) : bool
    {
        $query = "DELETE FROM Felhasznalo WHERE email=:email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        $returnable_bool = oci_execute($statement);
        oci_free_statement($statement);
        return $returnable_bool;
    }
    public function update_user(string $old_email, string $email, string $name, string $birthday, string $img_path, string $hashed_password) : bool
    {
        $query = "UPDATE Felhasznalo 
                  SET email=:email, nev=:name, szuletesi_datum=TO_DATE(:birth_date, 'yyyy-mm-dd'), jelszo=:password, profil_kep_utvonal=:path  
                  WHERE email=:old_email";
        $statement = oci_parse(parent::get_connection(), $query);
        oci_bind_by_name($statement, ":email", $email);
        oci_bind_by_name($statement, ":name", $name);
        oci_bind_by_name($statement, ":path", $img_path);
        oci_bind_by_name($statement, ":birth_date", $birthday);
        oci_bind_by_name($statement, ":password", $hashed_password);
        oci_bind_by_name($statement, ":old_email", $old_email);
        $returnable_bool = oci_execute($statement);
        oci_free_statement($statement);
        return $returnable_bool;
    }
    
}

?>