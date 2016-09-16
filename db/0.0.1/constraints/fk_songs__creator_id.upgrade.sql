DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_songs__creator_id') THEN
    ALTER TABLE songs
        ADD CONSTRAINT fk_songs__creator_id
        FOREIGN KEY (creator_id)
        REFERENCES users (user_id)
            ON DELETE SET NULL
            ON UPDATE CASCADE;
END IF;

END;
$$;