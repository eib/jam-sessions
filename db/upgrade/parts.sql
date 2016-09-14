CREATE TABLE IF NOT EXISTS parts (
    part_id bigserial PRIMARY KEY,
    song_id bigint NOT NULL,
    equipment_id bigint NOT NULL
);
