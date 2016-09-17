<?php

class DAL_Part {
    public static function listPartsForSong($song_id, PDO $db) {
        $sql = <<<EOD
SELECT *
FROM parts
WHERE song_id = :song_id
ORDER BY created_dt
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('song_id'));
        return $stmt->fetchAll();
    }

    public static function addPart($part, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
INSERT INTO parts (equipment_id, description, song_id, creator_id)
VALUES
(:equipment_id, :description, :song_id, :user_id)
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($part, ['equipment_id', 'description']);
        $params['user_id'] = $user_id;
        $params['song_id'] = $song_id;
        $stmt->execute($params);
        return $db->lastInsertId();
    }

    public static function updateParts($parts, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
UPDATE parts
SET
    equipment_id = :equipment_id,
    description = :description,
    modified_dt = NOW()
WHERE
    part_id = :part_id
    AND song_id = :song_id
    AND creator_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $num_affected = 0;
        foreach ($parts as $part) {
            $params = array_funnel_keys($part, ['part_id', 'equipment_id', 'description']);
            $params['user_id'] = $user_id;
            $params['song_id'] = $song_id;
            $stmt->execute($params);
            $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function deletePart($part_id, $song_id, $user_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM parts
WHERE
    part_id = :part_id
    AND song_id = :song_id
    AND creator_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('part_id', 'song_id', 'user_id'));
        return $stmt->rowCount() > 0;
    }
}
