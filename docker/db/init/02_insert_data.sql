-- Dane podstawow-- Wstawienie użytkownika administratora
INSERT INTO users (email, password, name, role) VALUES
    ('admin@admin.me', '$2y$10$cugrhjMSRuOP5AGEFAYOku8hpcYM0NUz2z4HH9EZO04jPleD/JyWe', 'Administrator', 'admin')
ON CONFLICT (email) DO NOTHING;
-- Hasło: admin

-- Wstawienie przykładowego użytkownika
INSERT INTO users (email, password, name, role) VALUES
    ('user@example.com', '$2y$10$LFt5Ls72uymG5rXpeQOXe.2ip9VUHhfnpDHH8/yhx1VyP.cNCAvfi', 'Test User', 'user')
ON CONFLICT (email) DO NOTHING;
-- Hasło: passwordkacji FilmVault
-- Wstawianie przykładowych danych

-- Wstawienie przykładowych gatunków
INSERT INTO genres (name) VALUES
    ('Action'),
    ('Drama'),
    ('Comedy'),
    ('Thriller'),
    ('Science Fiction'),
    ('Romance'),
    ('Horror'),
    ('Adventure'),
    ('Crime'),
    ('Fantasy')
ON CONFLICT (name) DO NOTHING;

-- Wstawienie ról w filmach
INSERT INTO roles (name) VALUES
    ('actor'),
    ('director'),
    ('screenwriter'),
    ('writer'),
    ('producer')
ON CONFLICT (name) DO NOTHING;-- Wstawienie użytkownika administratora
INSERT INTO users (email, password, name, role) VALUES
    ('admin@admin.me', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin')
ON CONFLICT (email) DO NOTHING;
-- Hasło: admin

-- Wstawienie przykładowego użytkownika
INSERT INTO users (email, password, name, role) VALUES
    ('user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', 'user')
ON CONFLICT (email) DO NOTHING;
-- Hasło: admin

-- Wstawienie przykładowych osób z branży filmowej
INSERT INTO people (first_name, last_name, birth_date, biography, image) VALUES
    ('Christopher', 'Nolan', '1970-07-30', 'British-American film director, producer, and screenwriter.', 'Person_Christopher_Nolan.jpg'),
    ('Leonardo', 'DiCaprio', '1974-11-11', 'American actor and film producer.', 'Person_Leonardo_DiCaprio.jpg'),
    ('Scarlett', 'Johansson', '1984-11-22', 'American actress and singer.', 'Person_Scarlett_Johansson.jpg'),
    ('Quentin', 'Tarantino', '1963-03-27', 'American film director, writer, and producer.', 'Person_Quentin_Tarantino.jpg'),
    ('Gal', 'Gadot', '1985-04-30', 'Israeli actress and model.', 'Person_Gal_Gadot.jpg'),
    ('Ryan', 'Gosling', '1980-11-12', 'Canadian actor and musician.', 'Person_Ryan_Gosling.jpg'),
    ('Emma', 'Stone', '1988-11-06', 'American actress.', 'Person_Emma_Stone.jpg')
ON CONFLICT DO NOTHING;

-- Wstawienie przykładowych filmów
INSERT INTO films (title, release_year, duration, image, description, rating) VALUES
    ('Interstellar', 2014, 169, 'Interstellar by Christopher Nolan Japanese alternative poster movie print.jpg', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity survival.', 8.6),
    ('La La Land', 2016, 128, 'La_La_Land.jpeg', 'A jazz musician and an aspiring actress fall in love while pursuing their dreams in Los Angeles.', 8.0),
    ('Parasite', 2019, 132, 'parasite.jpg', 'A poor family schemes to become employed by a wealthy family and infiltrate their household.', 8.5),
    ('Dunkirk', 2017, 106, 'dunkirk.jpeg', 'Allied soldiers from Belgium, the British Commonwealth and Empire, and France are surrounded by the German Army.', 7.8),
    ('A Quiet Place', 2018, 90, 'Queit_Place.jpg', 'A family lives in silence while hiding from creatures that hunt by sound.', 7.5)
ON CONFLICT DO NOTHING;

-- Powiązanie filmów z gatunkami
INSERT INTO film_genres (film_id, genre_id) VALUES
    -- Interstellar: Science Fiction, Drama, Adventure
    (1, (SELECT id FROM genres WHERE name = 'Science Fiction')),
    (1, (SELECT id FROM genres WHERE name = 'Drama')),
    (1, (SELECT id FROM genres WHERE name = 'Adventure')),

    -- La La Land: Romance, Comedy, Drama
    (2, (SELECT id FROM genres WHERE name = 'Romance')),
    (2, (SELECT id FROM genres WHERE name = 'Comedy')),
    (2, (SELECT id FROM genres WHERE name = 'Drama')),

    -- Parasite: Thriller, Drama, Crime
    (3, (SELECT id FROM genres WHERE name = 'Thriller')),
    (3, (SELECT id FROM genres WHERE name = 'Drama')),
    (3, (SELECT id FROM genres WHERE name = 'Crime')),

    -- Dunkirk: Drama, Thriller, Action
    (4, (SELECT id FROM genres WHERE name = 'Drama')),
    (4, (SELECT id FROM genres WHERE name = 'Thriller')),
    (4, (SELECT id FROM genres WHERE name = 'Action')),

    -- A Quiet Place: Horror, Thriller
    (5, (SELECT id FROM genres WHERE name = 'Horror')),
    (5, (SELECT id FROM genres WHERE name = 'Thriller'))
ON CONFLICT DO NOTHING;

-- Powiązanie filmów z osobami
INSERT INTO film_people (film_id, person_id, role) VALUES
    -- Interstellar
    (1, (SELECT id FROM people WHERE first_name = 'Christopher' AND last_name = 'Nolan'), 'director'),
    (1, (SELECT id FROM people WHERE first_name = 'Leonardo' AND last_name = 'DiCaprio'), 'actor'),

    -- La La Land
    (2, (SELECT id FROM people WHERE first_name = 'Ryan' AND last_name = 'Gosling'), 'actor'),
    (2, (SELECT id FROM people WHERE first_name = 'Emma' AND last_name = 'Stone'), 'actor'),

    -- Dunkirk
    (4, (SELECT id FROM people WHERE first_name = 'Christopher' AND last_name = 'Nolan'), 'director')
ON CONFLICT DO NOTHING;