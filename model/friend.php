<?php
//Lebutított User class
class Friend
{
    private string $name;
    //TODO image url??
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function get_name() : string { return $this->name; }

    public function set_name(string $name) : void { $this->name = $name; }

    public function to_string() : string
    {
        return "Name: ".$this->name;
        
    }

}