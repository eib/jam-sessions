DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'artist_name') THEN
    ALTER TABLE songs
        RENAME COLUMN artist_name TO band_name;
END IF;

END;
$$