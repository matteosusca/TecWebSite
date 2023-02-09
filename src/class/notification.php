<?php
class Notification {
    public $notification_id;
    public $recipient;
    public $sender;
    public $type;
    public $is_read;
    public $date;

    public function __construct($notification_id, $recipient, $sender, $type, $is_read, $date) {
        $this->notification_id = $notification_id;
        $this->recipient = $recipient;
        $this->sender = $sender;
        $this->type = $type;
        $this->is_read = $is_read;
        $this->date = $date;
    }
}

?>