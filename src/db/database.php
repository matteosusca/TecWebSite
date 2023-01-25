<?php
require_once 'user.php';
require_once 'squad.php';

class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function checkLogin($username, $mail, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM login WHERE (username=? OR mail=?) AND password=?");
        $stmt->bind_param('sss', $username, $mail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0;
    }

    public function checkUserExists($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM login WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function signUpUser($username, $mail, $password, $name, $surname, $date_of_birth)
    {
        if ($this->checkUserExists($username)) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO utente (username, mail, data_nascita, nome, cognome) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $username, $mail, $date_of_birth, $name, $surname);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO login (username, mail, password) VALUES (?,?,?)");
        $stmt->bind_param('sss', $username, $mail, $password);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    public function getUser($username)
    {
        if (!$this->checkUserExists($username)) {
            return false;
        }
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new User($result['username'], $result['mail'], $result['nome'], $result['cognome'], $result['data_nascita'], $result['profile_pic']);
    }

    public function getMediaUrl($idmedia)
    {
        $stmt = $this->db->prepare("SELECT url FROM media WHERE id_media=?");
        $stmt->bind_param('i', $idmedia);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        if (count($result) > 0) {
            return $result['url'];
        } else {
            return false;
        }
    }


    public function checkSquadExists($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM compagnia WHERE nome=?");
        $stmt->bind_param('i', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function createSquad($name, $description, $owner)
    {
        $stmt = $this->db->prepare("INSERT INTO compagnia (nome, descrizione, creatore) VALUES (?,?,?)");
        $stmt->bind_param('sss', $name, $description, $owner);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    public function getSquads($name)
    {
        if (!$this->checkSquadExists($name)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT compagnia.*, GROUP_CONCAT(partecipazione.username) AS membri FROM compagnia LEFT JOIN partecipazione ON compagnia.id_compagnia = partecipazione.id_compagnia WHERE compagnia.nome = ? GROUP BY compagnia.id_compagnia");
        $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach($result as $row){
            array_push($squads, new Squad($row['id_compagnia'], $row['nome'], $row['descrizione'], $row['profile_pic'], $row['creatore'], explode(",", $row['membri'])));
        }
        return $squads;
    }

    public function setName($username, $name)
    {
        $stmt = $this->db->prepare("UPDATE utente SET nome=? WHERE username=?");
        $stmt->bind_param('ss', $name, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setSurname($username, $surname)
    {
        $stmt = $this->db->prepare("UPDATE utente SET cognome=? WHERE username=?");
        $stmt->bind_param('ss', $surname, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setMail($username, $mail)
    {
        //check if mail is already in use
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE mail=?");
        $stmt->bind_param('s', $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        if (count($result->fetch_all(MYSQLI_ASSOC)) > 0) {
            return false;
        }
        //update mail
        $stmt = $this->db->prepare("UPDATE utente SET mail=? WHERE username=?");
        $stmt->bind_param('ss', $mail, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function createPost($username, $text, $media_id)
    {
        $id = $this->uploadMedia($media_id);
        if ($id) {
            $stmt = $this->db->prepare("INSERT INTO post (id_media, descrizione, data_pubblicazione, username) VALUES (?,?, NOW(),?)");
            $stmt->bind_param('iss', $id, $text, $username);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function setProfilePicture($username, $file)
    {
        //upload file to img folder
        $id = $this->uploadMedia($file);
        if ($id) {
            $stmt = $this->db->prepare("UPDATE utente SET profile_pic=? WHERE username=?");
            $stmt->bind_param('is', $id, $username);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function uploadMedia($file)
    {
        //upload file to img folder

        $target_dir = "img/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
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
                $stmt = $this->db->prepare("INSERT INTO media (url, tipo_media) VALUES (?, 'img')");
                $stmt->bind_param('s', $target_file);
                $stmt->execute();
                $stmt->close();
                return $this->db->insert_id;
            } else {
                return false;
            }
        }
    }

    public function isUserMember($username, $squadId){
        $stmt = $this->db->prepare("SELECT * FROM partecipazione WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC))>0;
    }

    public function checkUserPermissions($username, $squadId) {
        $stmt = $this->db->prepare("SELECT ruolo FROM partecipazione WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $row['ruolo'] != 3;
    }

    public function inviteUserToGroup($squadId, $hostUser, $inviteeUser, $role) {
        if(!isUserMember($hostUser, $squadId) || !checkUserPermissions($hostUser, $squadId)){
            return false;
        }
        if(isUserMember($inviteeUser, $squadId)){
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO partecipazione (username, id_compagnia, ruolo) VALUES (?, ?, ?)");
        $stmt->bind_param('sii', $inviteeUser, $squadId, $role);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getEventTypes() {
        $stmt = $this->db->prepare("SELECT * FROM tipo_evento");
        $stmt->execute();
        $result = $stmt->get_result();
        $types = array();
        while ($row = $result->fetch_assoc()) {
            $types[$row['id_tipo']] = $row['nome_tipo'];
        }
        return $types;
    }

}
?>