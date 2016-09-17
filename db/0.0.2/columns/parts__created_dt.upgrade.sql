DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'parts' and COLUMN_NAME = 'created_dt') THEN
    ALTER TABLE parts
        ADD COLUMN created_dt timestamp DEFAULT NOW();
END IF;

END;
$$