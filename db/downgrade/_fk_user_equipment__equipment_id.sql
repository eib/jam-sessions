DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_user_equipment__equipment_id') THEN
    ALTER TABLE user_equipment DROP CONSTRAINT fk_user_equipment__equipment_id;
END IF;

END;
$$;