<?php
class Like implements JsonSerializable
{
    private $user;
    private $id_post;
    private $date;

    public function __construct($id_post, $user, $date)
    {
        $this->id_post = $id_post;
        $this->user = $user;
        $this->date = $date;
    }

    public function getPostId()
    {
        return $this->id_post;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function jsonSerialize() {
        return [
            'id_post' => $this->id_post,
            'user' => $this->user,
            'date' => $this->date
        ];
    }
}