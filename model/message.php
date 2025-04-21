<?php
class Message
{
    private string $content;
    private bool $is_sender;
    public function __construct(string $content, int $is_sender)
    {
        $this->content = $content;
        $this->is_sender = $is_sender === 1;
    }
    public function get_content() : string { return $this->content; }
    public function is_sender() : bool { return $this->is_sender; }

    public function set_content(string $content) : void { $this->content = $content; }
    public function set_sender(bool $is_sender) : void { $this->is_sender = $is_sender; }

    public function __toString() : string
    {
        return "Content: ".$this->content.
                "\nSender: ".$this->is_sender ? "current user": "other user";
        
    }

}