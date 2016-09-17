DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = 'parts' and COLUMN_NAME = 'description') THEN
    ALTER TABLE parts
        ADD COLUMN description text DEFAULT NULL; --TODO: type, defaults?
END IF;

END;
$$