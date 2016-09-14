DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_friends__friend_id') THEN
    ALTER TABLE friends
        ADD CONSTRAINT fk_friends__friend_id
        FOREIGN KEY (friend_id)
        REFERENCES users (user_id);
END IF;

END;
$$;