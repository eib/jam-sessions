DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_parts__equipment_id') THEN
    ALTER TABLE parts
        ADD CONSTRAINT fk_parts__equipment_id
        FOREIGN KEY (equipment_id)
        REFERENCES equipment (equipment_id)
            ON DELETE CASCADE
            ON UPDATE CASCADE;
END IF;

END;
$$;