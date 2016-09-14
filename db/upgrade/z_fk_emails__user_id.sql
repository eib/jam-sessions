DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_emails__user_id') THEN
    ALTER TABLE emails
        ADD CONSTRAINT fk_emails__user_id
        FOREIGN KEY (user_id)
        REFERENCES users (user_id);
END IF;

END;
$$;