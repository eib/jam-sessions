DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_parts__song_id') THEN
    ALTER TABLE parts
        ADD CONSTRAINT fk_parts__song_id
        FOREIGN KEY (song_id)
        REFERENCES songs (song_id);
END IF;

END;
$$;