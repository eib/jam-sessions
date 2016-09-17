DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'parts' and COLUMN_NAME = 'modified_dt') THEN
    ALTER TABLE parts
        ADD COLUMN modified_dt timestamp DEFAULT NOW();
END IF;

END;
$$