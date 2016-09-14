SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = 'emails'
   AND CONSTRAINT_NAME = 'fk_emails__user_id';
