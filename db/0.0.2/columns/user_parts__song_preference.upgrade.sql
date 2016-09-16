DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'user_parts' and COLUMN_NAME = 'song_preference') THEN
    ALTER TABLE user_parts
        ADD COLUMN song_preference smallint DEFAULT 0;
END IF;

END;
$$