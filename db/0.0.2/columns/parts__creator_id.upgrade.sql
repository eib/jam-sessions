DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'parts' and COLUMN_NAME = 'creator_id') THEN
    ALTER TABLE parts
        ADD COLUMN creator_id bigint NOT NULL;
END IF;

END;
$$