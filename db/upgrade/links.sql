CREATE TABLE IF NOT EXISTS links (
    link_id bigserial PRIMARY KEY,
    url text NOT NULL
    --TODO: more features like "link type": tabs, audio tracks, etc?
    --TODO: add links to songs, parts, users, venues
);
