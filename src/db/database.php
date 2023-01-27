<?php
require_once 'templates/post.php';
require_once 'templates/comment.php';
require_once 'class/user.php';
require_once 'class/squad.php';

class DatabaseHelper
{
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

    public function checkLogin($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM login WHERE username=? AND password=?");
        $stmt->bind_param('ss', $username, $password);
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
        $stmt = $this->db->prepare("INSERT INTO utente (username, data_nascita, nome, cognome, email) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $username, $date_of_birth, $name, $surname, $mail);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO login (username, password) VALUES (?,?)");
        $stmt->bind_param('ss', $username, $password);
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
        return new User($result['username'], $result['email'], $result['nome'], $result['cognome'], $result['data_nascita'], $result['profile_pic']);
    }

    public function getPostComments($id_post)
    {
        $stmt = $this->db->prepare("SELECT * FROM commento WHERE id_post=?");
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $comments = array();
        foreach ($result as $row) {
            array_push($comments, new Comment($row['id_commento'], $row['id_post'], $row['username'], $row['corpo'], $row['data_pubblicazione']));
        }
        return $comments;
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

    public function getUsersPosts($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['id_post'], $this->getMediaUrl($row['id_media']), $row['username'], $row['descrizione'], $row['data_pubblicazione'], $this->getPostComments($row['id_post'])));
        }
        return $posts;
    }

    public function getPost($id_post){
        $stmt = $this->db->prepare("SELECT * FROM post WHERE id_post=?");
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Post($result['id_post'], $this->getMediaUrl($result['id_media']), $result['username'], $result['descrizione'], $result['data_pubblicazione'], $this->getPostComments($result['id_post']));
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

    public function getSquad($id)
    {
        $stmt = $this->db->prepare("SELECT compagnia.*, GROUP_CONCAT(partecipazione.username) AS membri FROM compagnia LEFT JOIN partecipazione ON compagnia.id_compagnia = partecipazione.id_compagnia WHERE compagnia.id_compagnia = ? GROUP BY compagnia.id_compagnia");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Squad($result['id_compagnia'], $result['nome'], $result['descrizione'], $result['profile_pic'], $result['creatore'], explode(",", $result['membri']));
    }

    public function getSquads($name)
    {
        if (!$this->checkSquadExists($name)) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT compagnia.*, GROUP_CONCAT(partecipazione.username) AS membri FROM compagnia LEFT JOIN partecipazione ON compagnia.id_compagnia = partecipazione.id_compagnia WHERE compagnia.nome = ? GROUP BY compagnia.id_compagnia");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach ($result as $row) {
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
        $stmt = $this->db->prepare("UPDATE utente SET email=? WHERE username=?");
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

    public function setSquadPicture($id_squad, $file)
    {
        //upload file to img folder
        $id_pic = $this->uploadMedia($file);
        if ($id_pic) {
            $stmt = $this->db->prepare("UPDATE compagnia SET profile_pic=? WHERE id_compagnia=?");
            $stmt->bind_param('ii', $id_pic, $id_squad);
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

    public function isUserMember($username, $squadId)
    {
        $stmt = $this->db->prepare("SELECT * FROM partecipazione WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function checkUserPermissionsForSquad($username, $squadId)
    {
        $stmt = $this->db->prepare("SELECT ruolo FROM partecipazione WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['ruolo'] != 3;
    }

    public function setSquadName($id, $name)
    {
        $stmt = $this->db->prepare("UPDATE compagnia SET nome=? WHERE id_compagnia=?");
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getEventTypes()
    {
        $stmt = $this->db->prepare("SELECT * FROM tipo_evento");
        $stmt->execute();
        $result = $stmt->get_result();
        $types = array();
        while ($row = $result->fetch_assoc()) {
            $types[$row['id_tipo']] = $row['nome_tipo'];
        }
        return $types;
    }
    public function createEvent($id_squad, $name, $description, $date_of_event_start, $date_of_event_end, $type, $username)
    {
        $stmt = $this->db->prepare("INSERT INTO evento (id_compagnia, nome, descrizione, data_creazione, data_evento, data_fine, id_tipo, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $date_of_creation = date("Y-m-d H:i:s");
        $stmt->bind_param('isssssis', $id_squad, $name, $description, $date_of_creation, $date_of_event_start, $date_of_event_end, $type, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    public function setSquadDescription($id, $description)
    {
        $stmt = $this->db->prepare("UPDATE compagnia SET descrizione=? WHERE id_compagnia=?");
        $stmt->bind_param('si', $description, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getFriends($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM amicizia WHERE richiedente=? OR accettante=?");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $friends = array();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            if ($row['richiedente'] == $username) {
                array_push($friends, $row['accettante']);
            } else {
                array_push($friends, $row['richiedente']);
            }
        }
        return $friends;
    }

    public function addFriend($username, $friend)
    {
        $stmt = $this->db->prepare("INSERT INTO amicizia (richiedente, accettante) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function checkIsUserCreator($username, $squadId)
    {
        $stmt = $this->db->prepare("SELECT * FROM partecipazione WHERE id_compagnia=? AND username=?");
        $stmt->bind_param('is', $squadId, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['ruolo'] == 1;
    }

    public function setUserAdmin($username, $squadId)
    {
        if ($this->checkIsUserCreator($username, $squadId)) {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE partecipazione SET ruolo=2 WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setUserMember($username, $squadId)
    {
        if ($this->checkIsUserCreator($username, $squadId)) {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE partecipazione SET ruolo=3 WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function removeUserFromSquad($username, $squadId)
    {
        if ($this->checkIsUserCreator($username, $squadId)) {
            return false;
        }
        $stmt = $this->db->prepare("DELETE FROM partecipazione WHERE username=? AND id_compagnia=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    public function getSquadsByUser($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM partecipazione WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $squads = array();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            array_push($squads, $row['id_compagnia']);
        }
        return $squads;
    }
    // public function inviteUserToGroup($squadId, $hostUser, $inviteeUser, $role)
    // {
    //     if (!isUserMember($hostUser, $squadId) || !checkUserPermissions($hostUser, $squadId)) {
    //         return false;
    //     }
    //     if (isUserMember($inviteeUser, $squadId)) {
    //         return false;
    //     }
    //     $stmt = $this->db->prepare("INSERT INTO partecipazione (username, id_compagnia, ruolo) VALUES (?, ?, ?)");
    //     $stmt->bind_param('sii', $inviteeUser, $squadId, $role);
    //     $stmt->execute();
    //     $stmt->close();
    //     return true;
    // }
}
