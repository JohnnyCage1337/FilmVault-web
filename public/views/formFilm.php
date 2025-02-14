
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="public/css/dashboard_style.css">
    <script src="https://kit.fontawesome.com/89efed05c9.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/filmValidation.js" defer></script>

</head>
<body>
<header>
    <div class="logo">
        <a href="dashboard"><img src="public\img\logo.svg"></a>
    </div>
    <form id="searchForm" method="get" action="search">
        <input type="search" name="q" placeholder="search project">
    </form>
    <?php if ($userId !== false): ?>
        <nav class="user">
            <a href="watchlist"><i class="fa-regular fa-bookmark" id="bookmark"></i></a>
            <?php if ($userRole === 'admin'): ?>
                <ul>
                    <li><a href="addPerson">Add film/person</a></li>
                    <li><a href="logout">Log out</a></li>
                </ul>
            <?php else: ?>
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

<nav class="form-switcher">
    <a href="/addFilm">Add film</a> |
    <a href="/addPerson">Add person</a>
</nav>

<main>
    <section class="films-form">
        <h1>Add film</h1>
        <h4>before adding a video, add all the necessary people in the "add person" tab</h4>

        <form id="film-form" action="/addFilm" method="POST" enctype="multipart/form-data">
            <input name="title" type="text" placeholder="Title" required>
            <input name="year" type="text" placeholder="Year" required>
            <input name="genre" type="text" placeholder="Genre1, Genre2, Genre3">
            <input name="people" type="text" placeholder="People-Type: Director1, Director2/Screenwriter1,.../Actor1(roleName), Actor2(roleSurname)">
            <input name="duration" type="text" placeholder="Duration">
            <input name="image" type="file" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit">Add film</button>
        </form>
    </section>
</main>

<footer>
    <nav>
        <ul class="nav-media">
            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
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
