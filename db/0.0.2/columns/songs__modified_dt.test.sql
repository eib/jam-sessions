SELECT 1/COUNT(*)
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'songs' and COLUMN_NAME = 'modified_dt';