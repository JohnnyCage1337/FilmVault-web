<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="public/css/details_style.css">
    <script src="https://kit.fontawesome.com/89efed05c9.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/watchlist.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="logo">
        <a href="dashboard"><img src="public\img\logo.svg"></a>
    </div>
    <form id="searchForm" method="get" action="search">
        <input type="search" name="q" placeholder="search project">
    </form>

    <?php if (isset($userRole) && ($userRole === 'admin' || $userRole === 'user')): ?>
        <nav class="user">
            <a href="watchlist"><i class="fa-regular fa-bookmark" id="bookmark"></i></a>

            <?php if ($userRole === 'admin'): ?>
                <ul>
                    <li><a href="addPerson">Add film/person</a></li>
                    <li><a href="logout">Log out</a></li>
                </ul>
            <?php elseif ($userRole === 'user'): ?>
                <a href="logout" class="logout-link">Log out</a>
            <?php endif; ?>
        </nav>
    <?php else: ?>
        <nav class="guest">
            <a href="login">SIGN IN</a>
            <a href="register">SIGN UP</a>
        </nav>
    <?php endif; ?>
</header>


<main>
    <div class="movie-container" id=<?= htmlspecialchars($film->getId()); ?>>
        <div class="poster">
            <img src="public/uploads/<?= htmlspecialchars($film->getImage()); ?>"
                 alt="<?= htmlspecialchars($film->getTitle()); ?>">
        </div>
        <div class="movie-details">
            <h1><?= htmlspecialchars($film->getTitle()); ?></h1>
            <p class="genre">
                <?php foreach ($film->getGenres() as $genre): ?>
                    <?= htmlspecialchars($genre) . ', '; ?>
                <?php endforeach; ?>
            </p>
            <div class="rating">
                <i class="fa-regular fa-star"></i> <?= htmlspecialchars($film->getRating()); ?>
            </div>

            <p><strong>Director(s):</strong>
                <?php foreach ($film->getDirectors() as $director): ?>
                    <?= htmlspecialchars($director->getFirstName()) . ' ' . $director->getLastName(); ?>
                <?php endforeach; ?>
            </p>

            <p><strong>Writer(s):</strong>
                <?php foreach ($film->getWriters() as $writer): ?>
                    <?= htmlspecialchars($writer->getFirstName()) . ' ' . $writer->getLastName()  . ', ';?>
                <?php endforeach; ?>
            </p>

            <p class="description"><?= htmlspecialchars($film->getDescription()); ?></p>
            <i class="fa-regular fa-bookmark"></i>
        </div>
    </div>


    <section class="casts">
        <h2>CASTS</h2>
        <div class="cast-list">
            <?php foreach ($film->getActors() as $actorFilm): ?>
                <?php

                $person = $actorFilm->getPerson();

                $characterFirstName = $actorFilm->getFistName();
                $characterLastName = $actorFilm->getLastName();
                $characterFullName = trim("$characterFirstName $characterLastName");
                ?>
                <div class="cast">
                    <img src="public/uploads/<?= htmlspecialchars($person->getImage() ?: 'default.jpg'); ?>"
                         alt="<?= htmlspecialchars($person->getFirstName() . ' ' . $person->getLastName()); ?>">

                    <p class="cast-name"><?= htmlspecialchars($person->getFirstName() . ' ' . $person->getLastName()); ?></p>
                    <p class="role"><?= htmlspecialchars($characterFullName); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>


<footer>
    <nav>
        <ul class="nav-media">
            <li id="tiktok"><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
            <li id="insta"><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            <li id="x"><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
            <li id="youtube"><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
            <li id="facebook"><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
        </ul>
    </nav>
    <nav>
        <ul class="policies">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Conditions of Use</a></li>
        </ul>
    </nav>
</footer>
</body>
</html>
