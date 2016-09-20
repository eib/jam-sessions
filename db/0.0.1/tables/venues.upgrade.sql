CREATE TABLE IF NOT EXISTS venues (
    venue_id bigserial PRIMARY KEY,
    venue_name text NOT NULL,
    venue_address text,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);
--TODO: creator_id?
