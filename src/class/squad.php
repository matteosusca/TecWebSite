<?php
require_once 'templates/head.php';
class Squad
{
    private $id;
    private $name;
    private $description;
    private $picture;
    private $owner;
    private $members;

    public function __construct($id, $name, $description, $picture, $owner, $members)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->picture = $picture;
        $this->owner = $owner;
        $this->members = $members;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getMembers()
    {
        return $this->members;
    }
    public function showSquad()
    {
        return '
        <a class="list-group-item list-group-item-action" href="squad.php?squad_id='
        . $this->getId() . '"><img src="'
        . $this->getPicture() . '" alt="" width="32" height="32" class="rounded-circle">'
        . $this->getName() . '</a>';
    }
}
