<?php
class Like implements JsonSerializable
{
    private $username;
    private $id_post;
    private $date;

    public function __construct($id_post, $username, $date)
    {
        $this->id_post = $id_post;
        $this->username = $username;
        $this->date = $date;
    }

    public function getPostId()
    {
        return $this->id_post;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function jsonSerialize() {
        return [
            'id_post' => $this->id_post,
            'username' => $this->username,
            'date' => $this->date
        ];
    }
}