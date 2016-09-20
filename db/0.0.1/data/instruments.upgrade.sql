INSERT INTO instruments (description)
VALUES
('Lead Guitar'),
('Rhythm Guitar'),
('Bass Guitar'),
('Drums'),
('Piano/Keyboard'),
('Lead Vocals'),
('Backing Vocals'),
('Cowbell')
ON CONFLICT DO NOTHING;