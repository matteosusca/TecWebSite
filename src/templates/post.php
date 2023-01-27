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

    public function getIdPost(){
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

    public function showComments(){
        $comments = '';
        foreach($this->comments as $comment){
            $comments .= $comment->showComment();
        }
        return $comments;
    }

    public function showPost(){
        return '
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">'.$this->getUsername().'</h5>
                    <p class="card-text">'.$this->getUsername().'</p>
                    <p class="card-text">'.$this->getDate().'</p>
                </div>
                <img src='.$this->getUrlMedia().' class="object-fit-contain" alt="..." height="455" />

                <div class="card-footer container-fluid d-flex flex-wrap justify-content-evenly" ">
                                <button type=" button" class="btn btn-outline-secondary border-0"><i class="bi bi-house d-block" style="font-size: 1rem;"></i>like</button>
                    <button type="button" class="btn btn-outline-secondary border-0"><i class="bi bi-pencil-square d-block" style="font-size: 1rem;"></i>comment</button>
                    <button type="button" class="btn btn-outline-secondary border-0" style="font-size: 1rem;"><i class="bi bi-share d-block" style="font-size: 1rem;"></i>share</button>
                    <button class="btn btn-outline-secondary border-0" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1">comment</button>
                </div>
                <div class="collapse multi-collapse" id="multiCollapseExample1">'.
                    $this->showComments()
                .'</div>
            </div>';
    }
}
?>