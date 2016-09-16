DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'user_parts' and COLUMN_NAME = 'skill_level') THEN
    ALTER TABLE user_parts
        ADD COLUMN skill_level smallint DEFAULT 0;
END IF;

END;
$$