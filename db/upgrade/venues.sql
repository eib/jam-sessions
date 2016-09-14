CREATE TABLE IF NOT EXISTS venues (
    venue_id bigserial PRIMARY KEY,
    venue_name text NOT NULL,
    venue_address text
);
