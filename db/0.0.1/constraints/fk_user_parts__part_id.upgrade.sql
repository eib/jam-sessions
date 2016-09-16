DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_user_parts__part_id') THEN
    ALTER TABLE user_parts
        ADD CONSTRAINT fk_user_parts__part_id
        FOREIGN KEY (part_id)
        REFERENCES parts (part_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
END IF;

END;
$$;