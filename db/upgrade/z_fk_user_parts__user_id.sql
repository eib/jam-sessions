DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_user_parts__user_id') THEN
    ALTER TABLE user_parts
        ADD CONSTRAINT fk_user_parts__user_id
        FOREIGN KEY (user_id)
        REFERENCES users (user_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
END IF;

END;
$$;