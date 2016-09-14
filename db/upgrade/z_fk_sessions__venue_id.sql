DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_sessions__venue_id') THEN
    ALTER TABLE sessions
        ADD CONSTRAINT fk_sessions__venue_id
        FOREIGN KEY (venue_id)
        REFERENCES venues (venue_id);
END IF;

END;
$$;