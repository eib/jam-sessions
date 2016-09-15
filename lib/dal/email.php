<?php
require_once('db.php');

class DAL_Email {

    public static function addEmailAddress($user_id, $email_address, PDO $db) {
        $sql = <<<EOD
INSERT INTO emails (user_id, email_address)
   SELECT :user_id, :email_address
   WHERE NOT EXISTS (SELECT 1 FROM emails WHERE user_id = :user_id AND email_address = :email_address);
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('user_id', 'email_address'));
    }
}
