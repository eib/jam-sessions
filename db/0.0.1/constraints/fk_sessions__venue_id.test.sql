SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = 'sessions'
   AND CONSTRAINT_NAME = 'fk_sessions__venue_id';
