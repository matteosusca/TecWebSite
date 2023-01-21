<?php
require_once 'bootstrap.php';
class User{
    private $username;
    private $email;
    private $name;
    private $surname;
    private $date_of_birth;
    private $profile_picture;

    public function __construct($username, $email, $name, $surname, $date_of_birth, $profile_picture){
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->date_of_birth = $date_of_birth;
        $this->profile_picture = $profile_picture;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getName(){
        return $this->name;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function getDateOfBirth(){
        return $this->date_of_birth;
    }

    public function getFullName(){
        return $this->name . " " . $this->surname;
    }

    public function getAge(){
        //print($this->date_of_birth);
        $date = new DateTime($this->date_of_birth);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }

    public function getProfilePicture(){
        return $this->profile_picture;
    }
}
?>