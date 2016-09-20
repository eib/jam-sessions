CREATE TABLE IF NOT EXISTS emails (
    email_id bigserial PRIMARY KEY,
    user_id bigint NOT NULL,
    email_address text NOT NULL,
    email_preference smallint default 0,
    is_deleted boolean default FALSE,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);

COMMENT ON COLUMN emails.email_preference IS 'How preferred an email address is compared to others -- closer to zero is more preferred.';
