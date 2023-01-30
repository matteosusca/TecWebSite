<?php
require_once 'class/post.php';
require_once 'class/comment.php';
require_once 'class/user.php';
require_once 'class/squad.php';
require_once 'class/event.php';

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
    public function signUpUser($username, $mail, $password, $name, $surname, $date_of_birth, $file)
    {
        if ($this->checkUserExists($username)) {
            return false;
        }
        $id = $this->uploadMedia($file);
        $stmt = $this->db->prepare("INSERT INTO utente (username, profile_pic, data_nascita, nome, cognome, email) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('sissss', $username, $id, $date_of_birth, $name, $surname, $mail);
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
            return null;
        }
        $stmt = $this->db->prepare("SELECT u.*, GROUP_CONCAT(f.username) AS amici
                                    FROM utente u
                                    INNER JOIN amicizia a ON u.username = a.richiedente OR u.username = a.accettante
                                    INNER JOIN utente f ON f.username = IF(u.username = a.richiedente, a.accettante, a.richiedente)
                                    WHERE u.username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        if(is_null($result['amici'])) {
            $amici = [];
        } else {
            $amici = explode(",", $result['amici']);
        }
        return new User($result['username'], $result['email'], $result['nome'], $result['cognome'], $result['data_nascita'], $this->getMediaUrl($result['profile_pic']), $amici);
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
        $id = mysqli_insert_id($this->db);
        $role = 1;
        $stmt = $this->db->prepare("INSERT INTO partecipazione (username, id_compagnia, ruolo) VALUES (?,?,?)");
        $stmt->bind_param('sii', $owner, $id, $role);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    public function getSquad($id)
    {
        $stmt = $this->db->prepare("SELECT compagnia.*, GROUP_CONCAT(partecipazione.username) AS membri 
                                    FROM compagnia 
                                    LEFT JOIN partecipazione 
                                    ON compagnia.id_compagnia = partecipazione.id_compagnia 
                                    WHERE compagnia.id_compagnia = ? 
                                    GROUP BY compagnia.id_compagnia");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Squad($result['id_compagnia'], $result['nome'], $result['descrizione'], $this->getMediaUrl($result['profile_pic']), $result['creatore'], explode(",", $result['membri']));
    }

    public function getSquads($name)
    {
        if (!$this->checkSquadExists($name)) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT compagnia.*, GROUP_CONCAT(partecipazione.username) AS membri FROM compagnia LEFT JOIN partecipazione ON compagnia.id_compagnia = partecipazione.id_compagnia WHERE compagnia.nome = ? GROUP BY compagnia.id_compagnia");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach ($result as $row) {
            array_push($squads, new Squad($row['id_compagnia'], $row['nome'], $row['descrizione'], $this->getMediaUrl($row['profile_pic']), $row['creatore'], explode(",", $row['membri'])));
        }
        return $squads;
    }

    public function getSquadsCreatedByUser($username) {
        if(!$this->checkUserExists($username)){
            return false;
        }
        $role = 1; 
        $stmt = $this->db->prepare("SELECT c.*, GROUP_CONCAT(u.username) as membri
                                    FROM compagnia c
                                    JOIN partecipazione p ON p.id_compagnia = c.id_compagnia
                                    JOIN utente u ON p.username = u.username
                                    WHERE p.username = ? AND p.ruolo = ? 
                                    GROUP BY c.id_compagnia");
        $stmt->bind_param('si',$username, $role);
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
        $stmt = $this->db->prepare("UPDATE utente SET email=? WHERE username=?");
        $stmt->bind_param('ss', $mail, $username);
        $stmt->execute();
        $stmt->close();
        return true;
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
        $target_file = $target_dir . $this->generateRandomName() . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
        $uploadOk = 1;
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
        while (file_exists($target_file)) {
            $target_file = $target_dir . $this->generateRandomName() . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
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

    private function generateRandomName()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
                array_push($friends, $this->getUser($row['accettante']));
            } else {
                array_push($friends,  $this->getUser($row['richiedente']));
            }
        }
        return $friends;
    }

    public function getFriendsUsername($username)
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
                array_push($friends,  $row['richiedente']);
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
            array_push($squads, $this->getSquad($row['id_compagnia']));
        }
        return $squads;
    }

    public function addUserToGroup($squadId, $hostUser, $inviteeUser, $role)
    {
        if (!$this->isUserMember($hostUser, $squadId)) {
            return false;
        }
        if ($this->isUserMember($inviteeUser, $squadId)) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO partecipazione (username, id_compagnia, ruolo) VALUES (?, ?, ?)");
        $stmt->bind_param('sii', $inviteeUser, $squadId, $role);
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

    public function createComment($username, $post_id, $body){
        $stmt = $this->db->prepare("INSERT INTO commento (id_post, username, corpo, data_pubblicazione) VALUES (?,?,?, NOW())");
        $stmt->bind_param('iss', $post_id, $username, $body);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getUserPosts($username)
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

    public function getPost($id_post)
    {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE id_post=?");
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Post($result['id_post'], $this->getMediaUrl($result['id_media']), $result['username'], $result['descrizione'], $result['data_pubblicazione'], $this->getPostComments($result['id_post']));
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

    public function getPostOrderByDate($username)
    {
        $friends = $this->getFriendsUsername($username);
        array_push($friends, $username);
        //implode solo del username dei friends che trovo con friends->getUsername()
        $friends = implode("','", $friends);
        $friends = "'" . $friends . "'";
        $stmt = $this->db->prepare("SELECT * FROM post WHERE username IN ($friends) ORDER BY data_pubblicazione DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['id_post'], $this->getMediaUrl($row['id_media']), $row['username'], $row['descrizione'], $row['data_pubblicazione'], $this->getPostComments($row['id_post'])));
        }
        return $posts;
    }

    public function getSquadPosts($squadId)
    {
        $squad = $this->getSquad($squadId);
        $members = $squad->getMembers();
        $members = implode("','", $members);
        $members = "'" . $members . "'";
        $stmt = $this->db->prepare("SELECT * FROM post WHERE username IN ($members) ORDER BY data_pubblicazione DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['id_post'], $this->getMediaUrl($row['id_media']), $row['username'], $row['descrizione'], $row['data_pubblicazione'], $this->getPostComments($row['id_post'])));
        }
        return $posts;
    }
    public function getMembers($squadId)
    {
        $squad = $this->getSquad($squadId);
        $members = $squad->getMembers();
        $members = implode("','", $members);
        $members = "'" . $members . "'";
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE username IN ($members)");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $members = array();
        foreach ($result as $row) {
            array_push($members, $this->getUser($row['username']));
        }
        return $members;
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

    public function getEvents($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia'], $row['Isc_username']));
        }
        return $events;
    }

    public function getUserEvents($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE (username=? or  (Isc_username=?))");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia'], $row['Isc_username']));
        }
        return $events;
    }
    public function getEvent($eventId)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE id_evento=?");
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Event($result['id_evento'], $result['nome'], $result['descrizione'], $result['data_creazione'], $result['data_evento'], $result['data_fine'], $result['id_tipo'], $result['username'], $result['id_compagnia']);
    }

    public function getEventsOrderByDate($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE username=? ORDER BY data_evento DESC");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia'], $row['Isc_username']));
        }
        return $events;
    }

    public function getSquadEvents($squadId)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE id_compagnia=?");
        $stmt->bind_param('i', $squadId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia'], $row['Isc_username']));
        }
        return $events;
    }

    public function setUserPosition($position,$username){
        $stmt = $this->db->prepare("UPDATE utente SET posizione=? WHERE username=?");
        $stmt->bind_param('ss', $position,$username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getUsersPosition($friendsusername){
        $friendsusername = implode("','",$friendsusername);
        $stmt = $this->db->prepare("SELECT username,posizione FROM utente WHERE username IN ('$friendsusername')");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = array();
        foreach ($result as $row) {
            array_push($users, $row['username'], $row['posizione']);
        }
        return $users;
    }

    public function inviteUserToEvent($eventId, $squadId, $username)
    {
        $stmt = $this->db->prepare("INSERT INTO invito_u (username , id_evento) VALUES (?, ?)");
        $stmt->bind_param('si', $username, $eventId);
        $stmt->execute();
        var_dump($stmt);
        $stmt->close();
        return true;


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
