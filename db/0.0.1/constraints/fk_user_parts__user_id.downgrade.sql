DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_user_parts__user_id') THEN
    ALTER TABLE user_parts DROP CONSTRAINT fk_user_parts__user_id;
END IF;

END;
$$;