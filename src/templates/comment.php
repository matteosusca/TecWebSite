<?php
Class Comment{
    private $id_commento;
    private $body;
    private $username;
    private $id_post;
    private $date;

    public function __construct($id_commento, $id_post, $username, $body, $date){
        $this->id_commento = $id_commento;
        $this->id_post = $id_post;
        $this->username = $username;
        $this->body = $body;
        $this->date = $date;
    }
    
    public function getIdCommento(){
        return $this->id_commento;
    }

    public function getIdPost(){
        return $this->id_post;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getBody(){
        return $this->body;
    }

    public function getDate(){
        return $this->date;
    }

    public function showComment(){
        return '
        <div class="card m-2">
            <div class="card-header">
                <p class="card-text">'.$this->getUsername().'</p>
                <p class="card-text">'.$this->getDate().'</p>
            </div>
            <div class="card card-body">
                <p class="card-text">'.$this->getBody().'</p>
            </div>
        </div>
    ';
    }
}
?>