<?php
require_once 'user.php';
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function __destruct(){
        $this->db->close();
    }

    public function checkLogin($username, $mail, $password){
        $stmt = $this->db->prepare("SELECT * FROM login WHERE (username=? OR mail=?) AND password=?");
        $stmt->bind_param('sss',$username, $mail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0;
    }

    public function checkUserExists($username){
        $stmt = $this->db->prepare("SELECT * FROM login WHERE username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC))>0;
    }

    public function signUpUser($username, $mail, $password, $name, $surname, $date_of_birth){
        if($this->checkUserExists($username)){
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO utente (username, mail, data_nascita, nome, cognome) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss',$username, $mail, $date_of_birth, $name, $surname);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO login (username, mail, password) VALUES (?,?,?)");
        $stmt->bind_param('sss',$username, $mail, $password);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    public function getUser($username){
        if(!$this->checkUserExists($username)){
            return false;
        }
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new User($result['username'], $result['mail'], $result['nome'], $result['cognome'], $result['data_nascita'], $result['profile_pic']);
    }

    public function getMediaUrl($idmedia){
        $stmt = $this->db->prepare("SELECT url FROM media WHERE id_media=?");
        $stmt->bind_param('i',$idmedia);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        if (count($result) > 0){
            return $result['url'];
        }else{
            return false;
        }
    } 


    public function checkSquadExists($name){
        $stmt = $this->db->prepare("SELECT * FROM compagnia WHERE nome=?");
        $stmt->bind_param('i',$name);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC))>0;
    }

    public function createSquad($name, $description, $owner) {
        $stmt = $this->db->prepare("INSERT INTO compagnia (nome, descrizione, creatore) VALUES (?,?,?)");
        $stmt->bind_param('sss', $name, $description, $owner);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    public function getSquads($name) {
        if(!$this->checkSquadExists($name)){
            return false;
        }
        $stmt = $this->db->prepare("SELECT * FROM compagnia WHERE nome=?");
        $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        print("merdacazzoculopalle");
        $squads = array();
        foreach($result as $row){
            array_push($squads, new Squad($row['id_compagnia'], $row['nome'], $row['descrizione'], $row['creatore'], $row['profile_pic']));
        }
        return $squads;
    }

}
?>