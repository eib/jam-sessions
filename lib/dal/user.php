<?php
require_once('db.php');

class DAL_User {

    public static function lookupOrCreate($user) {
        $db = DB::connect(); #TODO: I'd prefer DI. (But do callers REALLY need to pass the context down??)
        $sql = <<<EOD
INSERT INTO users (fb_id, name, first_name, middle_name, last_name, email)
   SELECT :id, :name, :first_name, :middle_name, :last_name, :email
   WHERE NOT EXISTS (SELECT 1 FROM users WHERE fb_id = :id);
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($user, [ 'id', 'name', 'first_name', 'middle_name', 'last_name', 'email' ]);
        $stmt->execute($params);

        $user_id = $db->lastInsertId();
        if ($user_id) {
            return self::fetch($user_id, $db);
        } else {
            return self::lookupByFBId($user['id'], $db);
        }
    }

    public static function fetch($user_id, PDO $db) {
        $sql = <<<EOD
SELECT *
FROM users
WHERE user_id = :user_id
LIMIT 1
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute([ 'user_id' => $user_id ]);
        return $stmt->fetch();
    }

    public static function lookupByFBId($fb_id, PDO $db) {
        $sql = <<<EOD
SELECT *
FROM users
WHERE fb_id = :fb_id
LIMIT 1
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute([ 'fb_id' => $fb_id ]);
        return $stmt->fetch();
    }
}
