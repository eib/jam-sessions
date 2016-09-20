<?php
require_once('db.php');
require_once('validator.php');

//PK fields: ['user_id', 'part_id']
//Non-PK fields: ['skill_level', 'song_preference', 'created_dt', 'modified_dt']

class DAL_UserPart {

    public static function batchUpdate($new, $modified, $deleted, $song_id, $user_id, PDO $db) {
        $db->beginTransaction();
        self::updateUserParts($modified, $song_id, $user_id, $db);
        self::addUserParts($new, $song_id, $user_id, $db);
        self::deleteUserParts($deleted, $song_id, $user_id, $db);
        $db->commit();
    }

    public static function deleteUserParts($old_rows, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM user_parts
WHERE part_id = :part_id AND user_id = :user_id
EOD;
        $stmt = $db->prepare($sql);

        $affected_rows = 0;
        foreach ($old_rows as $user_part) {
            $part_id = array_get($user_part, 'part_id_old'); //OLD part_id
            Validator::requirePositiveInt($part_id, 'Missing Part ID.');
            $params['part_id'] = $part_id;
            $params['user_id'] = $user_id;
            $stmt->execute($params);
            $affected_rows += $stmt->rowCount();
        }
        return $affected_rows;
    }

    public static function addUserParts($new_rows, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
INSERT INTO user_parts (user_id, part_id, skill_level, song_preference)
SELECT
    :user_id, :part_id, :skill_level, :song_preference
WHERE EXISTS (SELECT 1 FROM parts WHERE part_id = :part_id AND song_id = :song_id);
EOD;
        $stmt = $db->prepare($sql);

        $affected_rows = 0;
        foreach ($new_rows as $user_part) {
            Validator::requirePositiveInt($user_part['part_id'], 'Missing Part ID.');
            $params = array_funnel_keys($user_part, ['part_id', 'skill_level', 'song_preference']);
            $params['song_id'] = $song_id;
            $params['user_id'] = $user_id;
            $stmt->execute($params);
            $affected_rows += $stmt->rowCount();
        }
        return $affected_rows;
    }

    public static function updateUserParts($modified_rows, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
UPDATE user_parts
SET
    skill_level = :skill_level,
    song_preference = :song_preference,
    modified_dt = NOW()
WHERE
    part_id = :part_id
    AND user_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $num_affected = 0;
        foreach ($modified_rows as $user_part) {
            $params = array_funnel_keys($user_part, ['part_id', 'skill_level', 'song_preference']);
            $params['user_id'] = $user_id;
            $stmt->execute($params);
            $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function listUserPartsForSong($song_id, $user_id, $db) {
        $sql = <<<EOD
SELECT UP.*
FROM
    user_parts UP
    JOIN parts P ON(P.part_id = UP.part_id)
WHERE
    UP.user_id = :user_id
    AND P.song_id = :song_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('song_id', 'user_id'));
        return $stmt->fetchAll();
    }
}
