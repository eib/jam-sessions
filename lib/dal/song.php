<?php
require_once('db.php');

//Fields: 'song_id', 'song_title', 'artist_name', 'genre', 'key', 'year', 'creator_id', 'created_dt', 'modified_dt'
class DAL_Song {
    public static function listByUserId($user_id, PDO $db) {
        $sql = <<<EOD
SELECT *
FROM songs
WHERE creator_id = :user_id
ORDER BY created_dt
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('user_id'));
        return $stmt->fetchAll();
    }

    public static function updateSongs($songs, $user_id, PDO $db) {
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
    AND creator_id = :creator_id
EOD;
        $stmt = $db->prepare($sql);
        $num_affected = 0;
        foreach ($songs as $song) {
            $params = array_funnel_keys($song, ['song_id', 'song_title', 'artist_name', 'genre', 'key', 'year']);
            $params['creator_id'] = $user_id;
            $stmt->execute($params);
            $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function addSong($song, $user_id, PDO $db) {
        $sql = <<<EOD
INSERT INTO songs (song_title, artist_name, genre, key, year, creator_id)
VALUES
(:song_title, :artist_name, :genre, :key, :year, :user_id)
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($song, ['song_title', 'artist_name', 'genre', 'key', 'year']);
        $params['user_id'] = $user_id;
        $stmt->execute($params);
        return $db->lastInsertId();
    }

    public static function deleteSong($song_id, $user_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM songs
WHERE song_id = :song_id AND creator_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('song_id', 'user_id'));
        return $stmt->rowCount() > 0;
    }

    //TODO: [Feature] search additional songs within friendships?
}
