DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'song_title') THEN
    ALTER TABLE songs
        RENAME COLUMN song_title TO song_name;
END IF;

END;
$$