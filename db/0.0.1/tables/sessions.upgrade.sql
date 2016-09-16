CREATE TABLE IF NOT EXISTS sessions (
    session_id bigserial PRIMARY KEY,
    planner_id bigint NOT NULL,
    venue_id bigint,
    start_dt timestamp,
    end_dt timestamp
);
