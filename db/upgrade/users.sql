CREATE TABLE IF NOT EXISTS users (
    user_id bigserial PRIMARY KEY,
    fb_id text UNIQUE,
    email text DEFAULT NULL UNIQUE,
    name text NOT NULL,
    first_name text DEFAULT NULL,
    middle_name text DEFAULT NULL,
    last_name text DEFAULT NULL
);
