CREATE TABLE IF NOT EXISTS friends (
    user_id bigint,
    friend_id bigint,
    PRIMARY KEY (user_id, friend_id)
);
