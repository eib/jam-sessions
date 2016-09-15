<?php
require_once('db.php');
require_once('dal/email.php');

class DAL_User {

    public static function update($user) {
        Validator::requireTruthy($user, 'No user');
        Validator::requirePositiveInt($user['user_id'], 'User ID missing.');
        Validator::requireNonEmpty($user['user_name'], 'User Name missing.');

        $db = DB::connect();
        $sql = <<<EOD
UPDATE users
SET
    user_name = :user_name,
    full_name = :full_name,
    first_name = :first_name,
    middle_name = :middle_name,
    last_name = :last_name
WHERE user_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($user, ['user_id', 'user_name', 'full_name', 'first_name', 'middle_name', 'last_name']);
        $stmt->execute($params);
    }

    public static function lookupOrCreate($fb_user) {
        $db = DB::connect(); #TODO: I'd prefer DI. (But do callers REALLY need to pass the context down??)
        $sql = <<<EOD
INSERT INTO users (fb_id, user_name, full_name, first_name, middle_name, last_name)
   SELECT :id, :name, :name, :first_name, :middle_name, :last_name
   WHERE NOT EXISTS (SELECT 1 FROM users WHERE fb_id = :id);
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($fb_user, [ 'id', 'name', 'first_name', 'middle_name', 'last_name' ]);
        $stmt->execute($params);

        $user_id = $db->lastInsertId();
        if ($user_id) {
            $user = self::fetch($user_id, $db);
            $is_first_login = FALSE;
        } else {
            $user = self::lookupByFBId($fb_user['id'], $db);
            $user_id = $user['user_id'];
            $is_first_login = TRUE;
        }
        DAL_Email::addEmailAddress($user_id, $fb_user['email'], $db);
        return array($user, $is_first_login);
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
