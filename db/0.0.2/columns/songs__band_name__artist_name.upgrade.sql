DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'band_name') THEN
    ALTER TABLE songs
        RENAME COLUMN band_name TO artist_name;
END IF;

END;
$$