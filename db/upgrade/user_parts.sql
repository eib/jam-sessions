CREATE TABLE IF NOT EXISTS user_parts (
    user_id bigint,
    part_id bigint,
    -- TODO: features like: "how good I rate myself at this part", "how much I prefer playing this part (to other parts on the same song)"
    PRIMARY KEY (user_id, part_id)
);
