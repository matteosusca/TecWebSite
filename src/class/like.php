<?php
class Like implements JsonSerializable
{
    private $user_like;
    private $id_post;
    private $date;

    public function __construct($id_post, $user_like, $date)
    {
        $this->id_post = $id_post;
        $this->user_like = $user_like;
        $this->date = $date;
    }

    public function getPostId()
    {
        return $this->id_post;
    }

    public function getUser()
    {
        return $this->user_like;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function jsonSerialize() {
        return [
            'id_post' => $this->id_post,
            'user' => $this->user_like,
            'date' => $this->date
        ];
    }
}