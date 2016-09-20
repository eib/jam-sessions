CREATE TABLE IF NOT EXISTS user_parts (
    user_id bigint NOT NULL,
    part_id bigint NOT NULL,
    skill_level smallint DEFAULT 0,
    song_preference smallint DEFAULT 0,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now(),
    PRIMARY KEY (user_id, part_id)
);
