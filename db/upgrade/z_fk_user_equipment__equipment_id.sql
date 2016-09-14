DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_user_equipment__equipment_id') THEN
    ALTER TABLE user_equipment
        ADD CONSTRAINT fk_user_equipment__equipment_id
        FOREIGN KEY (equipment_id)
        REFERENCES equipment (equipment_id);
END IF;

END;
$$;