<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="public/css/dashboard_style.css">
    <script src="https://kit.fontawesome.com/89efed05c9.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="logo">
        <img src="public/img/logo.svg" alt="Logo">
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
        <section class="film-results">
            <?php if (isset($films) && count($films) > 0): ?>
                <?php foreach ($films as $film): ?>
                        <article class="film">
                            <div class="film-image-container">
                                <a href="details?id=<?= $film->getId() ?>">

                                <img src="public/uploads/<?= $film->getImage() ?>" alt="<?= htmlspecialchars($film->getTitle()) ?>" class="film-image">
                            </div>
                            <div class="film-details">
                                <a href="details?id=<?= $film->getId() ?>">

                                <h2 class="film-title"><?= $film->getTitle() ?></h2>
                                <p class="film-year-release"><?= $film->getYear() ?></p>
                                <p class="film-duration"><?= $film->getDuration() ?>'</p>
                                <div class="rate">
                                    <i class="fa-regular fa-star"></i>
                                    <span class="film-rating">
                                        <?= method_exists($film, 'getRating') ? $film->getRating() : '8.5'; ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Brak wyników wyszukiwania.</p>
            <?php endif; ?>
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
</div>
</body>
</html>
