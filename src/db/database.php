<?php
require_once 'class/post.php';
require_once 'class/comment.php';
require_once 'class/user.php';
require_once 'class/squad.php';
require_once 'class/event.php';
require_once 'class/like.php';
require_once 'class/notification.php';

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
        $stmt = $this->db->prepare("SELECT salt FROM login WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        $salt = $result['salt'];
        $password = hash('sha512', $password . $salt);
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
        //generate random salt using sha512
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password . $salt);
        $id = $this->uploadMedia($file);
        $stmt = $this->db->prepare("INSERT INTO utente (username, profile_pic, data_nascita, nome, cognome, email) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('sissss', $username, $id, $date_of_birth, $name, $surname, $mail);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO login (username, password, salt) VALUES (?,?,?)");
        $stmt->bind_param('sss', $username, $password, $salt);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO posizione (utente) VALUES (?)");
        $stmt->bind_param('s', $username);
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
        if (is_null($result['amici'])) {
            $amici = [];
        } else {
            $amici = explode(",", $result['amici']);
        }
        return new User($result['username'], $result['email'], $result['nome'], $result['cognome'], $result['data_nascita'], $this->getMediaUrl($result['profile_pic']), $amici);
    }

    function searchUser($username) {
        // Prepare the query
        $stmt = $this->db->prepare("SELECT username FROM utente WHERE username LIKE ? OR nome LIKE ? OR cognome LIKE ?");
        $username = "%".$username."%";
        $stmt->bind_param('sss', $username, $username, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = [];
        foreach ($result as $row) {
            $users[] = $this->getUser($row['username']);
        }
        return $users;
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
            return "";
        }
    }

    public function getNotifications($username) {
        $query = "SELECT * FROM notification WHERE recipient = ? ORDER BY notification_id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        //foreach row in result create a notification object
        $notifications = [];
        foreach ($result as $row) {
            $notifications[] = new Notification($row['notification_id'], $row['recipient'], $row['sender'], $row['type'], $row['isread'], $row['date'], $this->getMediaUrl($this->getProfilePicture($row['sender'])), $row['post_id']);
        }
        return $notifications;
        
    }

    public function createNotification($recipient, $sender, $type, $post_id=null) {
        $stmt = $this->db->prepare("INSERT INTO notification (recipient, sender, type, post_id) VALUES (?,?,?,?)");
        $stmt->bind_param('sssi', $recipient, $sender, $type, $post_id);
        $stmt->execute();
    }

    public function checkSquadExists($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM compagnia WHERE nome=?");
        $stmt->bind_param('i', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function createSquad($name, $description, $img, $owner)
    {
        $id = $this->uploadMedia($img);
        print("ID pic:" . $id);
        $stmt = $this->db->prepare("INSERT INTO compagnia (nome, descrizione, creatore, profile_pic) VALUES (?,?,?,?)");
        $stmt->bind_param('sssi', $name, $description, $owner, $id);
        $stmt->execute();
        $id = mysqli_insert_id($this->db);
        $role = 1;
        $stmt = $this->db->prepare("INSERT INTO partecipazione (username, id_compagnia, ruolo) VALUES (?,?,?)");
        $stmt->bind_param('sii', $owner, $id, $role);
        $stmt->execute();
        $stmt->close();

        return $id;
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

    public function getSquadImg($id)
    {
        $stmt = $this->db->prepare("SELECT profile_pic FROM compagnia WHERE id_compagnia=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return $this->getMediaUrl($result['profile_pic']);
    }

    public function removeSquad($id)
    {
        $stmt = $this->db->prepare("DELETE FROM compagnia WHERE id_compagnia=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        //delete all row with id from partecipazione
        $stmt = $this->db->prepare("DELETE FROM partecipazione WHERE id_compagnia=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        //delete from evento
        $stmt = $this->db->prepare("DELETE FROM evento WHERE id_compagnia=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function searchSquads($name)
    {
        $stmt = $this->db->prepare("SELECT c.id_compagnia 
        FROM compagnia c
        JOIN partecipazione p 
        ON c.id_compagnia = p.id_compagnia 
        WHERE c.nome LIKE ?
        AND p.username = ?;
        ");
        $name = '%' . $name . '%';
        $username = $_SESSION['username'];
        $stmt->bind_param('ss', $name, $username);
        error_log(print_r($username, true), 3, "/var/log/nginx/console.log");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach ($result as $row) {
            array_push($squads, $this->getSquad($row['id_compagnia']));
        }
        return $squads;
    }

    public function getSquadsCreatedByUser($username)
    {
        if (!$this->checkUserExists($username)) {
            return false;
        }
        $role = 1;
        $stmt = $this->db->prepare("SELECT c.*, GROUP_CONCAT(u.username) as membri
                                    FROM compagnia c
                                    JOIN partecipazione p ON p.id_compagnia = c.id_compagnia
                                    JOIN utente u ON p.username = u.username
                                    WHERE p.username = ? AND p.ruolo = ? 
                                    GROUP BY c.id_compagnia");
        $stmt->bind_param('si', $username, $role);
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

    public function getProfilePicture($username){
        $stmt = $this->db->prepare("SELECT profile_pic FROM utente WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return $result['profile_pic'];
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
        return !is_null($result) && $result['ruolo'] != 3;
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

    public function isFriendRequestPending($sender, $recipient) {
        $stmt = $this->db->prepare("SELECT * FROM richiesta_amicizia WHERE richiedente=? AND destinatario=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0;
    }

    public function addFriendRequest($username, $friend)
    {
        //check if request already exists
        $stmt = $this->db->prepare("SELECT * FROM richiesta_amicizia WHERE richiedente=? AND destinatario=?");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $result = $stmt->get_result();
        if (count($result->fetch_all(MYSQLI_ASSOC)) > 0) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO richiesta_amicizia (richiedente, destinatario) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $stmt->close();
        //send notification to friend
        $this->createNotification($friend, $username, 'friend_request');
        return true;
    }

    public function acceptRequest($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM richiesta_amicizia WHERE richiedente=? AND destinatario=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $stmt->close();
        $this->addFriend($sender, $recipient);
        $this->removeRequestNotification($recipient, $sender);
        return true;
    }

    public function declineRequest($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM richiesta_amicizia WHERE richiedente=? AND destinatario=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $stmt->close();
        $this->removeRequestNotification($recipient, $sender);
        return true;
    }

    public function removeRequestNotification($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM notification WHERE recipient=? AND sender=? AND type='friend_request'");
        $stmt->bind_param('ss', $recipient, $sender);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function addFriend($username, $friend)
    {
        $stmt = $this->db->prepare("INSERT INTO amicizia (richiedente, accettante) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function removeFriend($username, $friend)
    {
        $stmt = $this->db->prepare("DELETE FROM amicizia WHERE (richiedente=? AND accettante=?) OR (richiedente=? AND accettante=?)");
        $stmt->bind_param('ssss', $username, $friend, $friend, $username);
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
            //get the id of the post
            $id = $this->db->insert_id;
            //send a notification to all friends
            $friends = $this->getFriendsUsername($username);
            foreach ($friends as $friend) {
                $this->createNotification($friend, $username, "post", $id);
            }
            return true;
        }
        return false;
    }

    public function createComment($username, $post_id, $body)
    {
        $stmt = $this->db->prepare("INSERT INTO commento (id_post, username, corpo, data_pubblicazione) VALUES (?,?,?, NOW())");
        $stmt->bind_param('iss', $post_id, $username, $body);
        $stmt->execute();
        $stmt->close();
        //get the username of the post owner
        $post = $this->getPost($post_id);
        $postOwner = $post->getUsername();
        //if i'm not the owner send a notification to the post owner
        if ($postOwner != $username) {
            $this->createNotification($postOwner, $username, "comment", $post_id);
        }
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
        $inQuery = implode(",", array_fill(0, count($friends), "?"));
        $stmt = $this->db->prepare("SELECT * FROM post WHERE username IN ($inQuery) ORDER BY data_pubblicazione DESC");
        $stmt->bind_param(str_repeat('s', count($friends)), ...$friends);
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
        $placeholders = implode(',', array_fill(0, count($members), '?'));
        $stmt = $this->db->prepare("SELECT * FROM post WHERE username IN ($placeholders) ORDER BY data_pubblicazione DESC");
        $types = str_repeat('s', count($members));
        $stmt->bind_param($types, ...$members);
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
        $placeholders = implode(',', array_fill(0, count($members), '?'));
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE username IN ($placeholders)");
        $stmt->bind_param(str_repeat('s', count($members)), ...$members);
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
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia']));
        }
        return $events;
    }

    public function getUserEvents($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia']));
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
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia']));
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
            array_push($events, new Event($row['id_evento'], $row['nome'], $row['descrizione'], $row['data_creazione'], $row['data_evento'], $row['data_fine'], $row['id_tipo'], $row['username'], $row['id_compagnia']));
        }
        return $events;
    }

    public function setUserPosition($location, $username)
    {
        $stmt = $this->db->prepare("UPDATE posizione SET location=? WHERE utente=?");
        $stmt->bind_param('ss', $location, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    public function getUsersPosition($friendsusername)
    {
        $placeholders = implode(",", array_fill(0, count($friendsusername), "?"));
        $stmt = $this->db->prepare("SELECT * FROM posizione WHERE utente IN ($placeholders)");
        $stmt->bind_param(str_repeat("s", count($friendsusername)), ...$friendsusername);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = array();
        foreach ($result as $row) {
            $users[$row['utente']] = $row['location'];
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

    public function setLastActivity($user, $timestamp) {
        $stmt = $this->db->prepare("UPDATE accessi SET last_access=? WHERE utente=?");
        $stmt->bind_param('ss', $timestamp, $user);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getUsersLastActivity() {
        $stmt = $this->db->prepare("SELECT * FROM accessi");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = array();
        foreach ($result as $row) {
            $users[$row['utente']] = $row['last_access'];
        }
        return $users;
    }

    public function likePost($postId, $username) {
        $date = date("Y-m-d");
        $stmt = $this->db->prepare("INSERT INTO likes (username, id_post, data) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $username, $postId, $date);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function unlikePost($postId, $username) {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE username=? AND id_post=?");
        $stmt->bind_param('si', $username, $postId);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getPostLikes($postId) {
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE id_post=?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $likes = array();
        foreach ($result as $row) {
            array_push($likes, new Like($row['id_post'], $row['username'], $row['data']));
        }
        return $likes;
    }

    public function isLiked($postId, $username) {
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE id_post=? AND username=?");
        $stmt->bind_param('is', $postId, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0 ? true : false;
    }    

}
