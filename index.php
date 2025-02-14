<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'FilmController');
Routing::get('details', 'FilmController');
Routing::get('addToWatchList', 'FilmController');
Routing::get('watchlist', 'FilmController');

Routing::get('isGenreInDataBase', 'FilmController');
Routing::get('getAllGenres', 'FilmController');
Routing::get('isPeopleInDataBase', 'FilmController');



Routing::post('login', 'SecurityController');
Routing::post('addFilm', 'FilmController');
Routing::post('register', 'SecurityController');
Routing::post('search', 'FilmController');
Routing::post('addPerson', 'PersonController');
Routing::post('logout', 'SecurityController');
Routing::get('dashboard', 'FilmController');



Routing::run($path);

