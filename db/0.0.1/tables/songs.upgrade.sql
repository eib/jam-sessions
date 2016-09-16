CREATE TABLE IF NOT EXISTS songs (
    song_id bigserial PRIMARY KEY,
    song_name text NOT NULL,
    band_name text NOT NULL,
    creator_id bigint NOT NULL
);
-- TODO: key, year,
