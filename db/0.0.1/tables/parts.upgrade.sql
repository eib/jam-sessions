CREATE TABLE IF NOT EXISTS parts (
    part_id bigserial PRIMARY KEY,
    song_id bigint NOT NULL,
    instrument_id bigint NOT NULL,
    description text DEFAULT NULL,
    key text default NULL,
    tuning text default NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);