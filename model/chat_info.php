<?php
class ChatInfo
{
    private string $name;
    private string $profile_img_path;
    private string $last_message;
    public function __construct(string $name, string|null $profile_img_path, string $last_message="")
    {
        $this->name = $name;
        $this->profile_img_path = $profile_img_path ?? "../assets/default.png";
        $this->last_message = $last_message;
    }
    public function get_name() : string { return $this->name; }
    public function get_profile_img_path() : string { return $this->profile_img_path; }
    public function get_last_message() : string { return $this->last_message; }

    public function set_name(string $name) : void { $this->name = $name; }
    public function set_profile_img_path(string $profile_img_path) : void { $this->profile_img_path = $profile_img_path; }
    public function set_last_message(string $last_message) : void { $this->last_message = $last_message; }

    public function to_string() : string
    {
        return "Name: ".$this->name.
                "\nImage path: ".$this->profile_img_path.
                "\nLast message: ".$this->last_message;
        
    }

}