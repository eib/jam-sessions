CREATE TABLE IF NOT EXISTS user_equipment (
    user_equipment_id bigserial PRIMARY KEY,
    user_id bigint NOT NULL,
    equipment_id bigint NOT NULL,
    description text default NULL,
    manufacturer text default NULL,
    model text default NULL,
    product_year text default NULL,
    color text default NULL,
    created_dt timestamp default NOW(),
    modified_dt timestamp default NOW()
);
