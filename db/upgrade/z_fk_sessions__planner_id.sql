DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_sessions__planner_id') THEN
    ALTER TABLE sessions
        ADD CONSTRAINT fk_sessions__planner_id
        FOREIGN KEY (planner_id)
        REFERENCES users (user_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
END IF;

END;
$$;