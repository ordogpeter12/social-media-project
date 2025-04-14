<?php
class User
{
    private string $name;
    private string $email;
    private string $hashed_password;
    private string $role;
    private DateTime $birthday;
    //relative a view dir-hez képest
    private string $profile_img_path;

    public function __construct(string $name, string $email, string $hashed_password, string $role, DateTime $birthday, string|null $profile_img_path=null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->hashed_password = $hashed_password;
        $this->role = $role;
        $this->birthday = $birthday;
        $this->profile_img_path = $profile_img_path ?? "../assets/default.png";
    }
    public function get_name() : string { return $this->name; }
    public function get_email() : string { return $this->email; }
    public function get_hashed_password() : string { return $this->hashed_password; }
    public function get_role() : string { return $this->role; }
    public function get_birthday() : DateTime { return $this->birthday; }
    public function get_birthday_as_string() : string { return $this->birthday->format("Y-m-d"); }
    public function get_profile_img_path() : string { return $this->profile_img_path; }

    public function set_name(string $name) : void { $this->name = $name; }
    public function set_email(string $email) : void { $this->email = $email; }
    public function set_hashed_password(string $hashed_password) : void { $this->hashed_password = $hashed_password; }
    public function set_role(string $role) : void { $this->role = $role; }
    public function set_birthday(DateTime $birthday) : void { $this->birthday = $birthday; }
    public function set_profile_img_path(string $profile_img_path) : void { $this->profile_img_path = $profile_img_path; }

    public function to_string() : string
    {
        return "Name: ".$this->name.
                "\nEmail: ".$this->email.
                "\nRole: ".$this->role. 
                "\nBirthday: ".$this->birthday->format("Y-m-d").
                "\nProfile picture path: ".$this->profile_img_path;
        
    }

}
