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
    <h3>NEW RELEASES</h3>
    <section class="new-releases">
        <?php foreach ($newReleases as $newRelease): ?>
            <a href="details?id=<?= $newRelease->getId() ?>">
                <div class="film-card">
                    <img src="public/uploads/<?= $newRelease->getImage(); ?>" alt="<?= htmlspecialchars($newRelease->getTitle()); ?>">
                    <div class="overlay">
                        <div id="filmTitle">
                            <label><?= $newRelease->getTitle(); ?></label>
                        </div>
                        <div class="rate">
                            <label><?= $newRelease->getRating(); ?></label>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </section>


    <h3>TOP PICKS</h3>
    <section class="top-picks">
        <?php foreach ($topPicks as $topPick): ?>
            <a href="details?id=<?= $topPick->getId() ?>">
                <div class="film-card">
                    <img src="public/uploads/<?= $topPick->getImage(); ?>" alt="<?= htmlspecialchars($topPick->getTitle()); ?>">
                    <div class="overlay">
                        <div id="filmTitle">
                            <label><?= $topPick->getTitle(); ?></label>
                        </div>
                        <div class="rate">
                            <label><?= $topPick->getRating(); ?></label>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>

    <h3>RECOMMENDED</h3>
    <section class="recommended">
        <?php foreach ($recommendedFilms as $recommendendFilm): ?>
            <a href="details?id=<?= $recommendendFilm->getId() ?>">
                <div class="film-card">
                    <img src="public/uploads/<?= $recommendendFilm->getImage(); ?>" alt="<?= htmlspecialchars($recommendendFilm->getTitle()); ?>">
                    <div class="overlay">
                        <div id="filmTitle">
                            <label><?= $recommendendFilm->getTitle(); ?></label>
                        </div>
                        <div class="rate">
                            <label><?= $recommendendFilm->getRating(); ?></label>
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
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
