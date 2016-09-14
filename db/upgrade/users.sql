CREATE TABLE IF NOT EXISTS users (
    user_id bigserial PRIMARY KEY,
    fb_id text UNIQUE,
    user_name text NOT NULL,
    full_name text DEFAULT NULL,
    first_name text DEFAULT NULL,
    middle_name text DEFAULT NULL,
    last_name text DEFAULT NULL
);
