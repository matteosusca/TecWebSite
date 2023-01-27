<?php
require_once 'templates/head.php';
class Event
{
    private $id_event;

    private $name;
    private $description;
    private $date_of_creation;
    private $date_of_event_start;
    private $date_of_event_end;
    private $type;
    private $username;
    private $id_squad;
    private $sign_up_username;

    public function __construct($id_event, $name, $description, $date_of_creation, $date_of_event_start, $date_of_event_end, $type, $username, $id_squad, $sign_up_username)
    {
        $this->id_event = $id_event;
        $this->name = $name;
        $this->description = $description;
        $this->date_of_creation = $date_of_creation;
        $this->date_of_event_start = $date_of_event_start;
        $this->date_of_event_end = $date_of_event_end;
        $this->type = $type;
        $this->username = $username;
        $this->id_squad = $id_squad;
        $this->sign_up_username = $sign_up_username;
    }

    public function getIdEvent()
    {
        return $this->id_event;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDateOfCreation()
    {
        return $this->date_of_creation;
    }

    public function getDateOfEventStart()
    {
        return $this->date_of_event_start;
    }

    public function getDateOfEventEnd()
    {
        return $this->date_of_event_end;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getIdSquad()
    {
        return $this->id_squad;
    }

    public function getSignUpUsername()
    {
        return $this->sign_up_username;
    }
    public function showEvent(){
        return '
            <div class="card m-2">
                <div class="card-header">
                    <h5 class="card-title">'.$this->getName().'</h5>
                    <p class="card-text">'.$this->getUsername().'</p>
                    <p class="card-text">'.$this->getDescription().'</p>
                    <p class="card-text">'.$this->getDateOfEventStart().'</p>
                    <p class="card-text">'.$this->getDateOfEventEnd().'</p>
                </div>
            </div>';
    }
}
