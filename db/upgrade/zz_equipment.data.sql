INSERT INTO equipment (equipment_name)
VALUES
    ('Other'),
    ('Acoustic Guitar'),
    ('Electric Guitar'),
    ('Bass Guitar'),
    ('Drum Set'),
    ('Guitar Amp'),
    ('Bass Amp'),
    ('Keyboard'),
    ('PA System'),
    ('Microphone')
ON CONFLICT DO NOTHING;
