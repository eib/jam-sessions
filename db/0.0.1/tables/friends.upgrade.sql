CREATE TABLE IF NOT EXISTS friends (
    user_id bigint,
    friend_id bigint,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now(),
    PRIMARY KEY (user_id, friend_id)
);
