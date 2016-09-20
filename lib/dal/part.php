<?php

class DAL_Part {
    public static function listPartsForSong($song_id, PDO $db) {
        $sql = <<<EOD
SELECT P.*, I.description AS instrument_name
FROM
    parts P
    JOIN instruments I ON(I.instrument_id = P.instrument_id)
WHERE song_id = :song_id
ORDER BY created_dt
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('song_id'));
        return $stmt->fetchAll();
    }

    public static function addPart($part, $song_id, PDO $db) {
        $sql = <<<EOD
INSERT INTO parts (song_id, instrument_id, description, tuning, key)
VALUES
(:song_id, :instrument_id, :description, :tuning, :key)
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($part, ['instrument_id', 'description', 'tuning', 'key']);
        $params['song_id'] = $song_id;
        $stmt->execute($params);
        return $db->lastInsertId();
    }

    public static function updateParts($parts, $song_id, PDO $db) {
        $sql = <<<EOD
UPDATE parts
SET
    instrument_id = :instrument_id,
    description = :description,
    tuning = :tuning,
    key = :key,
    modified_dt = NOW()
WHERE
    part_id = :part_id
    AND song_id = :song_id
EOD;
        $stmt = $db->prepare($sql);
        $num_affected = 0;
        foreach ($parts as $part) {
            $params = array_funnel_keys($part, ['part_id', 'instrument_id', 'description', 'tuning', 'key']);
            $params['song_id'] = $song_id;
            $stmt->execute($params);
            $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function deletePart($part_id, $song_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM parts
WHERE
    part_id = :part_id
    AND song_id = :song_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('part_id', 'song_id'));
        return $stmt->rowCount() > 0;
    }

    public static function listInstruments(PDO $db) {
        $sql = 'SELECT * FROM instruments ORDER BY instrument_id';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
