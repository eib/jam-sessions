DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_parts__creator_id') THEN
    ALTER TABLE parts
        ADD CONSTRAINT fk_parts__creator_id
        FOREIGN KEY (creator_id)
        REFERENCES users (user_id)
            -- TODO: ON DELETE ???
            -- TODO: ON UPDATE ???
        ;
END IF;

END;
$$;