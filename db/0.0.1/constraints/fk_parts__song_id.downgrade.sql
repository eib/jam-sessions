DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_parts__song_id') THEN
    ALTER TABLE parts DROP CONSTRAINT fk_parts__song_id;
END IF;

END;
$$;