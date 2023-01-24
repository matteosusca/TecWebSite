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
        $squads = [];
        foreach($result as $row){
            $squads[] = new Squad($row['id_compagnia'], $row['nome'], $row['descrizione'], $row['creatore'], $row['profile_pic']);
        }
        return $squads;
    }

    public function setProfilePicture($username, $file){
        //upload file to img folder
        
        $target_dir = "img/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($file["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($file["size"] > 500000) {
            //$uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                //update media table
                $target_file = $target_file;
                print($target_file);
                $stmt = $this->db->prepare("INSERT INTO media (url, tipo_media) VALUES (?, 'img')");
                $stmt->bind_param('s', $target_file);
                $stmt->execute();
                $stmt->close();
                $media_id = $this->db->insert_id;
                //update user table
                $stmt = $this->db->prepare("UPDATE utente SET profile_pic=? WHERE username=?");
                $stmt->bind_param('is', $media_id, $username);
                $stmt->execute();
                $stmt->close();
                return true;
            } else {
                return false;
            }
        }
    }

    public function setName($username, $name){
        $stmt = $this->db->prepare("UPDATE utente SET nome=? WHERE username=?");
        $stmt->bind_param('ss', $name, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setSurname($username, $surname){
        $stmt = $this->db->prepare("UPDATE utente SET cognome=? WHERE username=?");
        $stmt->bind_param('ss', $surname, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setMail($username, $mail){
        //check if mail is already in use
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE mail=?");
        $stmt->bind_param('s',$mail);
        $stmt->execute();
        $result = $stmt->get_result();
        if(count($result->fetch_all(MYSQLI_ASSOC))>0){
            return false;
        }
        //update mail
        $stmt = $this->db->prepare("UPDATE utente SET mail=? WHERE username=?");
        $stmt->bind_param('ss', $mail, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

}
?>