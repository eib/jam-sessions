DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_friends__user_id') THEN
    ALTER TABLE friends
        ADD CONSTRAINT fk_friends__user_id
        FOREIGN KEY (user_id)
        REFERENCES users (user_id);
END IF;

END;
$$;