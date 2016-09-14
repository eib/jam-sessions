CREATE TABLE IF NOT EXISTS user_equipment (
    user_equipment_id bigserial PRIMARY KEY,
    user_id bigint NOT NULL,
    equipment_id bigint NOT NULL,
    description text NOT NULL
);
