DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_parts__instrument_id') THEN
    ALTER TABLE parts
        ADD CONSTRAINT fk_parts__instrument_id
        FOREIGN KEY (instrument_id)
        REFERENCES instruments (instrument_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
END IF;

END;
$$;