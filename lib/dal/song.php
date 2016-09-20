<?php
require_once('db.php');

//Fields: 'song_id', 'song_title', 'artist_name', 'genre', 'key', 'year', 'created_dt', 'modified_dt'
class DAL_Song {
    public static function fetch($song_id, PDO $db) {
        $sql = <<<EOD
SELECT * FROM songs
WHERE
    song_id = :song_id
LIMIT 1
EOD;
        $stmt = $db->prepare($sql);
        if (!$stmt->execute(compact('song_id'))) {
            return FALSE;
        }
        return $stmt->fetch();
    }

    public static function listAll(PDO $db) {
        $sql = <<<EOD
SELECT *
FROM songs
ORDER BY created_dt
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function listAllWithParts(PDO $db) {
        $sql = <<<EOD
SELECT
    S.*,
    (SELECT COUNT(*) FROM parts P WHERE P.song_id = S.song_id) AS num_parts,
    (SELECT COUNT(*) FROM user_parts UP JOIN parts P ON(P.part_id = UP.part_id) WHERE P.song_id = S.song_id) AS num_user_parts
FROM songs S
WHERE EXISTS(SELECT 1 FROM parts P WHERE P.song_id = S.song_id)
ORDER BY S.artist_name, S.song_title
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function updateSongs($songs, PDO $db) {
        $sql = <<<EOD
UPDATE songs
SET
    song_title = :song_title,
    artist_name = :artist_name,
    genre = :genre,
    key = :key,
    year = :year,
    modified_dt = NOW()
WHERE
    song_id = :song_id
EOD;
        $stmt = $db->prepare($sql);
        $num_affected = 0;
        foreach ($songs as $song) {
            $params = array_funnel_keys($song, ['song_id', 'song_title', 'artist_name', 'genre', 'key', 'year']);
            $stmt->execute($params);
            $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function addSong($song, PDO $db) {
        $sql = <<<EOD
INSERT INTO songs (song_title, artist_name, genre, key, year)
VALUES
(:song_title, :artist_name, :genre, :key, :year)
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($song, ['song_title', 'artist_name', 'genre', 'key', 'year']);
        $stmt->execute($params);
        return $db->lastInsertId();
    }

    public static function deleteSong($song_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM songs
WHERE song_id = :song_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('song_id'));
        return $stmt->rowCount() > 0;
    }

    //TODO: [Feature] search additional songs within friendships?
}
