CREATE TABLE IF NOT EXISTS songs (
    song_id bigserial PRIMARY KEY,
    song_title text NOT NULL,
    artist_name text NOT NULL,
    genre text default NULL,
    key text default NULL,
    year text default NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);
