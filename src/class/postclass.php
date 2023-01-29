<?php
Class Post{
    private $id_post;
    private $url_media;
    private $username;
    private $description;
    private $date;
    private $comments;

    public function __construct($id_post, $url_media, $username, $description, $date, $comments){
        $this->id_post = $id_post;
        $this->url_media = $url_media;
        $this->username = $username;
        $this->description = $description;
        $this->date = $date;
        $this->comments = $comments;
    }

    public function getId(){
        return $this->id_post;
    }
    
    public function getUrlMedia(){
        return $this->url_media;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getDate(){
        return $this->date;
    }
}
?>


