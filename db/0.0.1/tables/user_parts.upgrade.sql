CREATE TABLE IF NOT EXISTS user_parts (
    user_id bigint,
    part_id bigint,
    PRIMARY KEY (user_id, part_id)
);
