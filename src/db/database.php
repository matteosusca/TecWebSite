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
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $row = $result->fetch_assoc();
        $salt = $row['salt'];
        $password = hash('sha512', $password . $salt);
        $stmt = $this->db->prepare("SELECT * FROM login WHERE username=? AND password=?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
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
        $stmt = $this->db->prepare("INSERT INTO users (username, profile_pic, birth_date, name, surname, email) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('sissss', $username, $id, $date_of_birth, $name, $surname, $mail);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO login (username, password, salt) VALUES (?,?,?)");
        $stmt->bind_param('sss', $username, $password, $salt);
        $stmt->execute();
        $stmt = $this->db->prepare("INSERT INTO positions (username) VALUES (?)");
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
                                    FROM users u
                                    INNER JOIN friendships a ON u.username = a.sender OR u.username = a.recipient
                                    INNER JOIN users f ON f.username = IF(u.username = a.sender, a.recipient, a.sender)
                                    WHERE u.username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        if (is_null($result['amici'])) {
            $amici = [];
        } else {
            $amici = explode(",", $result['amici']);
        }
        return new User($result['username'], $result['email'], $result['name'], $result['surname'], $result['birth_date'], $this->getMediaUrl($result['profile_pic']), $amici);
    }

    function searchUser($username) {
        // Prepare the query
        $stmt = $this->db->prepare("SELECT username FROM users WHERE username LIKE ? OR name LIKE ? OR surname LIKE ?");
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
        $query = "SELECT * FROM notifications WHERE recipient = ? ORDER BY notification_id DESC";
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
        $stmt = $this->db->prepare("INSERT INTO notifications (recipient, sender, type, post_id) VALUES (?,?,?,?)");
        $stmt->bind_param('sssi', $recipient, $sender, $type, $post_id);
        $stmt->execute();
    }

    public function checkSquadExists($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM squads WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function createSquad($name, $description, $img, $owner)
    {
        $id = $this->uploadMedia($img);
        print("ID pic:" . $id);
        $stmt = $this->db->prepare("INSERT INTO squads (name, description, owner, profile_pic) VALUES (?,?,?,?)");
        $stmt->bind_param('sssi', $name, $description, $owner, $id);
        $stmt->execute();
        $id = mysqli_insert_id($this->db);
        $role = 1;
        $stmt = $this->db->prepare("INSERT INTO participations (username, squad_id, role) VALUES (?,?,?)");
        $stmt->bind_param('sii', $owner, $id, $role);
        $stmt->execute();
        $stmt->close();

        return $id;
    }

    public function getSquad($id)
    {
        if (!$this->checkSquadExists($id)) {
            return null;
        }
        $stmt = $this->db->prepare("SELECT squads.*, GROUP_CONCAT(participations.username) AS membri 
                                    FROM squads 
                                    LEFT JOIN participations 
                                    ON squads.squad_id = participations.squad_id 
                                    WHERE squads.squad_id = ? 
                                    GROUP BY squads.squad_id");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Squad($result['squad_id'], $result['name'], $result['description'], $this->getMediaUrl($result['profile_pic']), $result['owner'], explode(",", $result['membri']));
    }

    public function getSquadImg($id)
    {
        $stmt = $this->db->prepare("SELECT profile_pic FROM squads WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return $this->getMediaUrl($result['profile_pic']);
    }

    public function removeSquad($id)
    {
        //delete all row with id from partecipazione
        $stmt = $this->db->prepare("DELETE FROM participations WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        //get a list of all events id of the squad
        $events = $this->getSquadEvents($id);
        //delete all row from invito_u where id_evento is in the list
        $stmt = $this->db->prepare("DELETE FROM u_invitations WHERE event_id=?");
        foreach ($events as $event) {
            $event_id = $event->getIdEvent();
            $stmt->bind_param('i', $event_id);
            $stmt->execute();
        }
        //delete from evento
        $stmt = $this->db->prepare("DELETE FROM events WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt = $this->db->prepare("DELETE FROM squads WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

    }

    public function searchSquads($name)
    {
        $stmt = $this->db->prepare("SELECT c.squad_id 
        FROM squads c
        JOIN participations p 
        ON c.squad_id = p.squad_id 
        WHERE c.name LIKE ?
        AND p.username = ?;
        ");
        $name = '%' . $name . '%';
        $username = $_SESSION['username'];
        $stmt->bind_param('ss', $name, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach ($result as $row) {
            array_push($squads, $this->getSquad($row['squad_id']));
        }
        return $squads;
    }

    public function getSquadOwner($id)
    {
        $stmt = $this->db->prepare("SELECT owner FROM squads WHERE squad_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return $result['owner'];
    }

    public function getSquadsCreatedByUser($username)
    {
        if (!$this->checkUserExists($username)) {
            return false;
        }
        $role = 1;
        $stmt = $this->db->prepare("SELECT c.*, GROUP_CONCAT(u.username) as membri
                                    FROM squads c
                                    JOIN participations p ON p.squad_id = c.squad_id
                                    JOIN users u ON p.username = u.username
                                    WHERE p.username = ? AND p.role = ? 
                                    GROUP BY c.squad_id");
        $stmt->bind_param('si', $username, $role);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $squads = array();
        foreach ($result as $row) {
            array_push($squads, new Squad($row['squad_id'], $row['name'], $row['description'], $row['profile_pic'], $row['owner'], explode(",", $row['membri'])));
        }
        return $squads;
    }

    public function setName($username, $name)
    {
        $stmt = $this->db->prepare("UPDATE users SET name=? WHERE username=?");
        $stmt->bind_param('ss', $name, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setSurname($username, $surname)
    {
        $stmt = $this->db->prepare("UPDATE users SET surname=? WHERE username=?");
        $stmt->bind_param('ss', $surname, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setMail($username, $mail)
    {
        $stmt = $this->db->prepare("UPDATE users SET email=? WHERE username=?");
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
            $stmt = $this->db->prepare("UPDATE users SET profile_pic=? WHERE username=?");
            $stmt->bind_param('is', $id, $username);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function getProfilePicture($username){
        $stmt = $this->db->prepare("SELECT profile_pic FROM users WHERE username=?");
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
            $stmt = $this->db->prepare("UPDATE squads SET profile_pic=? WHERE squad_id=?");
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
                $stmt = $this->db->prepare("INSERT INTO media (url, media_type) VALUES (?, 'img')");
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
        $stmt = $this->db->prepare("SELECT * FROM participations WHERE username=? AND squad_id=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
    }

    public function checkUserPermissionsForSquad($username, $squadId)
    {
        $stmt = $this->db->prepare("SELECT role FROM participations WHERE username=? AND squad_id=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return !is_null($result) && $result['role'] != 3;
    }

    public function setSquadName($id, $name)
    {
        $stmt = $this->db->prepare("UPDATE squads SET name=? WHERE squad_id=?");
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function setSquadDescription($id, $description)
    {
        $stmt = $this->db->prepare("UPDATE squads SET description=? WHERE squad_id=?");
        $stmt->bind_param('si', $description, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getFriends($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM friendships WHERE sender=? OR recipient=?");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $friends = array();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($result as $row) {
            if ($row['sender'] == $username) {
                array_push($friends, $this->getUser($row['recipient']));
            } else {
                array_push($friends,  $this->getUser($row['sender']));
            }
        }
        return $friends;
    }

    public function getFriendsUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM friendships WHERE sender=? OR recipient=?");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $friends = array();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($result as $row) {
            if ($row['sender'] == $username) {
                array_push($friends, $row['recipient']);
            } else {
                array_push($friends,  $row['sender']);
            }
        }
        return $friends;
    } 

    public function isFriendRequestPending($sender, $recipient) {
        $stmt = $this->db->prepare("SELECT * FROM friend_requests WHERE sender=? AND recipient=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0;
    }

    public function addFriendRequest($username, $friend)
    {
        //check if request already exists
        $stmt = $this->db->prepare("SELECT * FROM friend_requests WHERE sender=? AND recipient=?");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $result = $stmt->get_result();
        if (count($result->fetch_all(MYSQLI_ASSOC)) > 0) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO friend_requests (sender, recipient) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $stmt->close();
        //send notification to friend
        $this->createNotification($friend, $username, 'friend_request');
        return true;
    }

    public function acceptRequest($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM friend_requests WHERE sender=? AND recipient=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $stmt->close();
        $this->addFriend($sender, $recipient);
        $this->removeRequestNotification($recipient, $sender);
        return true;
    }

    public function declineRequest($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM friend_requests WHERE sender=? AND recipient=?");
        $stmt->bind_param('ss', $sender, $recipient);
        $stmt->execute();
        $stmt->close();
        $this->removeRequestNotification($recipient, $sender);
        return true;
    }

    public function removeRequestNotification($recipient, $sender){
        $stmt = $this->db->prepare("DELETE FROM notifications WHERE recipient=? AND sender=? AND type='friend_request'");
        $stmt->bind_param('ss', $recipient, $sender);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function addFriend($username, $friend)
    {
        $stmt = $this->db->prepare("INSERT INTO friendships (sender, recipient) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $friend);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function removeFriend($username, $friend)
    {
        $stmt = $this->db->prepare("DELETE FROM friendships WHERE (sender=? AND recipient=?) OR (sender=? AND recipient=?)");
        $stmt->bind_param('ssss', $username, $friend, $friend, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function checkIsUserCreator($username, $squadId)
    {
        $stmt = $this->db->prepare("SELECT * FROM participations WHERE squad_id=? AND username=?");
        $stmt->bind_param('is', $squadId, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['role'] == 1;
    }

    public function setUserAdmin($username, $squadId)
    {
        if ($this->checkIsUserCreator($username, $squadId)) {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE participations SET role=2 WHERE username=? AND squad_id=?");
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
        $stmt = $this->db->prepare("UPDATE participations SET role=3 WHERE username=? AND squad_id=?");
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
        $stmt = $this->db->prepare("DELETE FROM u_invitations WHERE username = ? AND event_id IN (SELECT event_id FROM events WHERE squad_id = ?)");
        $stmt = $this->db->prepare("DELETE FROM participations WHERE username=? AND squad_id=?");
        $stmt->bind_param('si', $username, $squadId);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    public function getSquadsByUser($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM participations WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $squads = array();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            array_push($squads, $this->getSquad($row['squad_id']));
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
        $stmt = $this->db->prepare("INSERT INTO participations (username, squad_id, role) VALUES (?, ?, ?)");
        $stmt->bind_param('sii', $inviteeUser, $squadId, $role);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function createPost($username, $text, $media_id)
    {
        $id = $this->uploadMedia($media_id);
        if ($id) {
            $stmt = $this->db->prepare("INSERT INTO posts (id_media, description, publication_date, username) VALUES (?,?, NOW(),?)");
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
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, username, body, publication_date) VALUES (?,?,?, NOW())");
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
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['post_id'], $this->getMediaUrl($row['id_media']), $row['username'], $row['description'], $row['publication_date'], $this->getPostComments($row['post_id'])));
        }
        return $posts;
    }

    public function getPost($post_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE post_id=?");
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Post($result['post_id'], $this->getMediaUrl($result['id_media']), $result['username'], $result['description'], $result['publication_date'], $this->getPostComments($result['post_id']));
    }


    public function getPostComments($post_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE post_id=?");
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $comments = array();
        foreach ($result as $row) {
            array_push($comments, new Comment($row['comment_id'], $row['post_id'], $row['username'], $row['body'], $row['publication_date']));
        }
        return $comments;
    }

    public function getPostOrderByDate($username)
    {
        $friends = $this->getFriendsUsername($username);
        array_push($friends, $username);
        $inQuery = implode(",", array_fill(0, count($friends), "?"));
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE username IN ($inQuery) ORDER BY publication_date DESC");
        $stmt->bind_param(str_repeat('s', count($friends)), ...$friends);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['post_id'], $this->getMediaUrl($row['id_media']), $row['username'], $row['description'], $row['publication_date'], $this->getPostComments($row['post_id'])));
        }
        return $posts;
    }

    public function getSquadPosts($squadId)
    {
        $squad = $this->getSquad($squadId);
        $members = $squad->getMembers();
        $placeholders = implode(',', array_fill(0, count($members), '?'));
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE username IN ($placeholders) ORDER BY publication_date DESC");
        $types = str_repeat('s', count($members));
        $stmt->bind_param($types, ...$members);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $posts = array();
        foreach ($result as $row) {
            array_push($posts, new Post($row['post_id'], $this->getMediaUrl($row['id_media']), $row['username'], $row['description'], $row['publication_date'], $this->getPostComments($row['post_id'])));
        }
        return $posts;
    }

    public function getMembers($squadId)
    {
        $squad = $this->getSquad($squadId);
        $members = $squad->getMembers();
        $placeholders = implode(',', array_fill(0, count($members), '?'));
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username IN ($placeholders)");
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
        $stmt = $this->db->prepare("SELECT * FROM event_types");
        $stmt->execute();
        $result = $stmt->get_result();
        $types = array();
        while ($row = $result->fetch_assoc()) {
            $types[$row['type_id']] = $row['type_name'];
        }
        return $types;
    }
    public function createEvent($id_squad, $name, $description, $date_of_event_start, $date_of_event_end, $type, $username)
    {
        $stmt = $this->db->prepare("INSERT INTO events (squad_id, name, description, creation_date, event_date, end_event_date, type_id, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $date_of_creation = date("Y-m-d H:i:s");
        $stmt->bind_param('isssssis', $id_squad, $name, $description, $date_of_creation, $date_of_event_start, $date_of_event_end, $type, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getEvents($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['event_id'], $row['name'], $row['description'], $row['creation_date'], $row['event_date'], $row['end_event_date'], $row['type_id'], $row['username'], $row['squad_id']));
        }
        return $events;
    }

    

    public function getUserEvents($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['event_id'], $row['name'], $row['description'], $row['creation_date'], $row['event_date'], $row['end_event_date'], $row['type_id'], $row['username'], $row['squad_id']));
        }
        return $events;
    }
    public function getEvent($eventId)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE event_id=?");
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        return new Event($result['event_id'], $result['name'], $result['description'], $result['creation_date'], $result['event_date'], $result['end_event_date'], $result['type_id'], $result['username'], $result['squad_id']);
    }

    public function getEventsOrderByDate($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE username=? ORDER BY event_date DESC");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['event_id'], $row['name'], $row['description'], $row['creation_date'], $row['event_date'], $row['end_event_date'], $row['type_id'], $row['username'], $row['squad_id']));
        }
        return $events;
    }

    public function getPublicEventsOrderByDate()
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE type_id=1 ORDER BY event_date DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['event_id'], $row['name'], $row['description'], $row['creation_date'], $row['event_date'], $row['end_event_date'], $row['type_id'], $row['username'], $row['squad_id']));
        }
        return $events;
    }

    public function getSquadEvents($squadId)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE squad_id=?");
        $stmt->bind_param('i', $squadId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $events = array();
        foreach ($result as $row) {
            array_push($events, new Event($row['event_id'], $row['name'], $row['description'], $row['creation_date'], $row['event_date'], $row['end_event_date'], $row['type_id'], $row['username'], $row['squad_id']));
        }
        return $events;
    }

    public function setUserPosition($location, $username)
    {
        $stmt = $this->db->prepare("UPDATE positions SET location=? WHERE username=?");
        $stmt->bind_param('ss', $location, $username);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    public function getUsersPosition($friendsusername)
    {
        $placeholders = implode(",", array_fill(0, count($friendsusername), "?"));
        $stmt = $this->db->prepare("SELECT * FROM positions WHERE username IN ($placeholders)");
        $stmt->bind_param(str_repeat("s", count($friendsusername)), ...$friendsusername);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = array();
        foreach ($result as $row) {
            $users[$row['username']] = $row['location'];
        }
        return $users;
    }
    
    public function inviteUserToEvent($eventId, $squadId, $username)
    {
        $stmt = $this->db->prepare("INSERT INTO u_invitations (username , event_id) VALUES (?, ?)");
        $stmt->bind_param('si', $username, $eventId);
        $stmt->execute();
        var_dump($stmt);
        $stmt->close();
        return true;
    }

    public function setLastActivity($users, $timestamp) {
        $stmt = $this->db->prepare("UPDATE access SET last_access=? WHERE username=?");
        $stmt->bind_param('ss', $timestamp, $users);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getUsersLastActivity() {
        $stmt = $this->db->prepare("SELECT * FROM access");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $users = array();
        foreach ($result as $row) {
            $users[$row['username']] = $row['last_access'];
        }
        return $users;
    }

    public function likePost($postId, $username) {
        $date = date("Y-m-d");
        $stmt = $this->db->prepare("INSERT INTO likes (username, post_id, data) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $username, $postId, $date);
        $stmt->execute();
        $stmt->close();
        //notificate post owner
        $stmt = $this->db->prepare("SELECT username FROM posts WHERE post_id=?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        $postOwner = $result['username'];
        if($postOwner != $username){
            $this->createNotification($postOwner, $username, "like", $postId);
        }
        return true;
    }

    public function unlikePost($postId, $username) {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE username=? AND post_id=?");
        $stmt->bind_param('si', $username, $postId);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getPostLikes($postId) {
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE post_id=?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $likes = array();
        foreach ($result as $row) {
            array_push($likes, new Like($row['post_id'], $row['username'], $row['data']));
        }
        return $likes;
    }

    public function isLiked($postId, $username) {
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE post_id=? AND username=?");
        $stmt->bind_param('is', $postId, $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($result) > 0 ? true : false;
    }    

}
