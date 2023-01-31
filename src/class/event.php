<?php
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

    public function __construct($id_event, $name, $description, $date_of_creation, $date_of_event_start, $date_of_event_end, $type, $username, $id_squad)
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
}
