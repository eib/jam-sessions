--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.4
-- Dumped by pg_dump version 9.5.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: emails; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE emails (
    email_id bigint NOT NULL,
    user_id bigint NOT NULL,
    email_address text NOT NULL,
    email_preference smallint DEFAULT 0,
    is_deleted boolean DEFAULT false,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE emails OWNER TO postgres;

--
-- Name: COLUMN emails.email_preference; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN emails.email_preference IS 'How preferred an email address is compared to others -- closer to zero is more preferred.';


--
-- Name: emails_email_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE emails_email_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE emails_email_id_seq OWNER TO postgres;

--
-- Name: emails_email_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE emails_email_id_seq OWNED BY emails.email_id;


--
-- Name: equipment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE equipment (
    equipment_id bigint NOT NULL,
    equipment_name text NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE equipment OWNER TO postgres;

--
-- Name: equipment_equipment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE equipment_equipment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE equipment_equipment_id_seq OWNER TO postgres;

--
-- Name: equipment_equipment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE equipment_equipment_id_seq OWNED BY equipment.equipment_id;


--
-- Name: friends; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE friends (
    user_id bigint NOT NULL,
    friend_id bigint NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE friends OWNER TO postgres;

--
-- Name: instruments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE instruments (
    instrument_id bigint NOT NULL,
    description text NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE instruments OWNER TO postgres;

--
-- Name: instruments_instrument_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE instruments_instrument_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE instruments_instrument_id_seq OWNER TO postgres;

--
-- Name: instruments_instrument_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE instruments_instrument_id_seq OWNED BY instruments.instrument_id;


--
-- Name: links; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE links (
    link_id bigint NOT NULL,
    url text NOT NULL,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE links OWNER TO postgres;

--
-- Name: links_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE links_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE links_link_id_seq OWNER TO postgres;

--
-- Name: links_link_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE links_link_id_seq OWNED BY links.link_id;


--
-- Name: parts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE parts (
    part_id bigint NOT NULL,
    song_id bigint NOT NULL,
    instrument_id bigint NOT NULL,
    description text,
    key text,
    tuning text,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE parts OWNER TO postgres;

--
-- Name: parts_part_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE parts_part_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parts_part_id_seq OWNER TO postgres;

--
-- Name: parts_part_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE parts_part_id_seq OWNED BY parts.part_id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE sessions (
    session_id bigint NOT NULL,
    planner_id bigint NOT NULL,
    venue_id bigint,
    start_dt timestamp without time zone,
    end_dt timestamp without time zone,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE sessions OWNER TO postgres;

--
-- Name: sessions_session_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sessions_session_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sessions_session_id_seq OWNER TO postgres;

--
-- Name: sessions_session_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sessions_session_id_seq OWNED BY sessions.session_id;


--
-- Name: songs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE songs (
    song_id bigint NOT NULL,
    song_title text NOT NULL,
    artist_name text NOT NULL,
    genre text,
    key text,
    year text,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE songs OWNER TO postgres;

--
-- Name: songs_song_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE songs_song_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE songs_song_id_seq OWNER TO postgres;

--
-- Name: songs_song_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE songs_song_id_seq OWNED BY songs.song_id;


--
-- Name: user_equipment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_equipment (
    user_equipment_id bigint NOT NULL,
    user_id bigint NOT NULL,
    equipment_id bigint NOT NULL,
    description text,
    manufacturer text,
    model text,
    product_year text,
    color text,
    created_dt timestamp without time zone DEFAULT now(),
    modified_dt timestamp without time zone DEFAULT now()
);


ALTER TABLE user_equipment OWNER TO postgres;

--
-- Name: user_equipment_user_equipment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_equipment_user_equipment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_equipment_user_equipment_id_seq OWNER TO postgres;

--
-- Name: user_equipment_user_equipment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE user_equipment_user_equipment_id_seq OWNED BY user_equipment.user_equipment_id;


--
-- Name: user_parts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_parts (
    user_id bigint NOT NULL,
    part_id bigint NOT NULL,
    skill_level smallint DEFAULT 0,
    song_preference smallint DEFAULT 0,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE user_parts OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE users (
    user_id bigint NOT NULL,
    fb_id text,
    user_name text NOT NULL,
    full_name text,
    first_name text,
    middle_name text,
    last_name text,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE users OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_user_id_seq OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_user_id_seq OWNED BY users.user_id;


--
-- Name: venues; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE venues (
    venue_id bigint NOT NULL,
    venue_name text NOT NULL,
    venue_address text,
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);


ALTER TABLE venues OWNER TO postgres;

--
-- Name: venues_venue_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE venues_venue_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE venues_venue_id_seq OWNER TO postgres;

--
-- Name: venues_venue_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE venues_venue_id_seq OWNED BY venues.venue_id;


--
-- Name: email_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY emails ALTER COLUMN email_id SET DEFAULT nextval('emails_email_id_seq'::regclass);


--
-- Name: equipment_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY equipment ALTER COLUMN equipment_id SET DEFAULT nextval('equipment_equipment_id_seq'::regclass);


--
-- Name: instrument_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY instruments ALTER COLUMN instrument_id SET DEFAULT nextval('instruments_instrument_id_seq'::regclass);


--
-- Name: link_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY links ALTER COLUMN link_id SET DEFAULT nextval('links_link_id_seq'::regclass);


--
-- Name: part_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parts ALTER COLUMN part_id SET DEFAULT nextval('parts_part_id_seq'::regclass);


--
-- Name: session_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sessions ALTER COLUMN session_id SET DEFAULT nextval('sessions_session_id_seq'::regclass);


--
-- Name: song_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY songs ALTER COLUMN song_id SET DEFAULT nextval('songs_song_id_seq'::regclass);


--
-- Name: user_equipment_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_equipment ALTER COLUMN user_equipment_id SET DEFAULT nextval('user_equipment_user_equipment_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN user_id SET DEFAULT nextval('users_user_id_seq'::regclass);


--
-- Name: venue_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY venues ALTER COLUMN venue_id SET DEFAULT nextval('venues_venue_id_seq'::regclass);


--
-- Name: emails_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY emails
    ADD CONSTRAINT emails_pkey PRIMARY KEY (email_id);


--
-- Name: equipment_equipment_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY equipment
    ADD CONSTRAINT equipment_equipment_name_key UNIQUE (equipment_name);


--
-- Name: equipment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY equipment
    ADD CONSTRAINT equipment_pkey PRIMARY KEY (equipment_id);


--
-- Name: friends_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY friends
    ADD CONSTRAINT friends_pkey PRIMARY KEY (user_id, friend_id);


--
-- Name: instruments_description_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY instruments
    ADD CONSTRAINT instruments_description_key UNIQUE (description);


--
-- Name: instruments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY instruments
    ADD CONSTRAINT instruments_pkey PRIMARY KEY (instrument_id);


--
-- Name: links_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY links
    ADD CONSTRAINT links_pkey PRIMARY KEY (link_id);


--
-- Name: parts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parts
    ADD CONSTRAINT parts_pkey PRIMARY KEY (part_id);


--
-- Name: sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (session_id);


--
-- Name: songs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY songs
    ADD CONSTRAINT songs_pkey PRIMARY KEY (song_id);


--
-- Name: user_equipment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_equipment
    ADD CONSTRAINT user_equipment_pkey PRIMARY KEY (user_equipment_id);


--
-- Name: user_parts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_parts
    ADD CONSTRAINT user_parts_pkey PRIMARY KEY (user_id, part_id);


--
-- Name: users_fb_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_fb_id_key UNIQUE (fb_id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: venues_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY venues
    ADD CONSTRAINT venues_pkey PRIMARY KEY (venue_id);


--
-- Name: fk_emails__user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY emails
    ADD CONSTRAINT fk_emails__user_id FOREIGN KEY (user_id) REFERENCES users(user_id);


--
-- Name: fk_friends__friend_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY friends
    ADD CONSTRAINT fk_friends__friend_id FOREIGN KEY (friend_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_friends__user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY friends
    ADD CONSTRAINT fk_friends__user_id FOREIGN KEY (user_id) REFERENCES users(user_id);


--
-- Name: fk_parts__instrument_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parts
    ADD CONSTRAINT fk_parts__instrument_id FOREIGN KEY (instrument_id) REFERENCES instruments(instrument_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_parts__song_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parts
    ADD CONSTRAINT fk_parts__song_id FOREIGN KEY (song_id) REFERENCES songs(song_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_sessions__planner_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sessions
    ADD CONSTRAINT fk_sessions__planner_id FOREIGN KEY (planner_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_sessions__venue_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sessions
    ADD CONSTRAINT fk_sessions__venue_id FOREIGN KEY (venue_id) REFERENCES venues(venue_id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: fk_user_equipment__equipment_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_equipment
    ADD CONSTRAINT fk_user_equipment__equipment_id FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_user_equipment__user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_equipment
    ADD CONSTRAINT fk_user_equipment__user_id FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_user_parts__part_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_parts
    ADD CONSTRAINT fk_user_parts__part_id FOREIGN KEY (part_id) REFERENCES parts(part_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: fk_user_parts__user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_parts
    ADD CONSTRAINT fk_user_parts__user_id FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

