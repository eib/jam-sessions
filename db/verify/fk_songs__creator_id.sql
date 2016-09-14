SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = 'songs'
   AND CONSTRAINT_NAME = 'fk_songs__creator_id';
