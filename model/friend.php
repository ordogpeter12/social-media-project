<?php
//Lebutított User class
class Friend
{
    private string $name;
    private string $profile_img_path;
    private string $friend_status;
    public function __construct(string $name, string|null $profile_img_path, string|null $friend_status=null)
    {
        $this->name = $name;
        $this->profile_img_path = $profile_img_path ?? "../assets/default.png";
        $this->friend_status = $friend_status ?? 's';
    }
    public function get_name() : string { return $this->name; }
    public function get_profile_img_path() : string { return $this->profile_img_path; }
    public function get_friend_status() : string { return $this->friend_status; }

    public function set_name(string $name) : void { $this->name = $name; }
    public function set_profile_img_path(string $profile_img_path) : void { $this->profile_img_path = $profile_img_path; }
    public function set_friend_status(string $friend_status) : void { $this->friend_status = $friend_status; }

    public function to_string() : string
    {
        return "Name: ".$this->name.
                "\nImage path: ".$this->profile_img_path;
        
    }

}