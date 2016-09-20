CREATE TABLE IF NOT EXISTS equipment (
    equipment_id bigserial PRIMARY KEY,
    equipment_name text UNIQUE NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);
