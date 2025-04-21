<?php
include_once "message.php";
class Chat
{
    private string $name;
    private string $profile_img_path;
    private array $messages;
    public function __construct(string $name, string|null $profile_img_path, array $messages=[])
    {
        $this->name = $name;
        $this->profile_img_path = $profile_img_path ?? "../assets/default.png";
        $this->messages = $messages;
    }
    public function get_name() : string { return $this->name; }
    public function get_profile_img_path() : string { return $this->profile_img_path; }
    public function get_messages() : array { return $this->messages; }

    public function add_message(Message $message) : void { $message[] = $message; }
    public function set_name(string $name) : void { $this->name = $name; }
    public function set_profile_img_path(string $profile_img_path) : void { $this->profile_img_path = $profile_img_path; }
    public function set_messages(array $messages) : void { $this->messages = $messages; }

    public function __toString() : string
    {
        return "Name: ".$this->name.
                "\nImage path: ".$this->profile_img_path.
                "\nMessages: ".implode('\n', $this->messages);
        
    }

}