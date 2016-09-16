DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_sessions__planner_id') THEN
    ALTER TABLE sessions DROP CONSTRAINT fk_sessions__planner_id;
END IF;

END;
$$;