SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = 'user_parts'
   AND CONSTRAINT_NAME = 'fk_user_parts__user_id';
