CREATE TABLE IF NOT EXISTS instruments (
    instrument_id bigserial PRIMARY KEY,
    description text UNIQUE NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);
