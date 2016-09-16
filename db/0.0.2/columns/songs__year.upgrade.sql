DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'year') THEN
    ALTER TABLE songs
        ADD COLUMN year text DEFAULT NULL;
END IF;

END;
$$