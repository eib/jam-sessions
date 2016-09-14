SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = 'user_equipment'
   AND CONSTRAINT_NAME = 'fk_user_equipment__equipment_id';
