<?php
require_once 'templates/head.php';
class Event
{
    private $id_event;
    private $id_squad;
    private $name;
    private $description;
    private $surname;
    private $date_of_creation;
    private $date_of_event_start;
    private $date_of_event_end;
    private $username;
    private $sign_up_username;

    public function __construct($id_event, $id_squad, $name, $description, $surname, $date_of_creation, $date_of_event_start, $date_of_event_end, $username, $sign_up_username)
    {
        $this->id_event = $id_event;
        $this->id_squad = $id_squad;
        $this->name = $name;
        $this->description = $description;
        $this->surname = $surname;
        $this->date_of_creation = $date_of_creation;
        $this->date_of_event_start = $date_of_event_start;
        $this->date_of_event_end = $date_of_event_end;
        $this->username = $username;
        $this->sign_up_username = $sign_up_username;
    }

    public function getIdEvent()
    {
        return $this->id_event;
    }

    public function getIdSquad()
    {
        return $this->id_squad;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSurname()
    {
        return $this->surname;
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

    public function getUsername()
    {
        return $this->username;
    }

    public function getSignUpUsername()
    {
        return $this->sign_up_username;
    }
}
