DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'song_name') THEN
    ALTER TABLE songs
        RENAME COLUMN song_name TO song_title;
END IF;

END;
$$