
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="public/css/dashboard_style.css">
    <script src="https://kit.fontawesome.com/89efed05c9.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/personValidation.js" defer></script>

</head>
<body>
<header>
    <div class="logo">
        <img src="public/img/logo.svg" alt="Logo">
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
        <h1>Add person</h1>
        <?php if(isset($messages)){
            foreach ($messages as $message){
                echo $message;
            }
        }

        ?>
        <form id="person-form" action="/addPerson" method="POST" enctype="multipart/form-data">
            <input name="first_name" type="text" placeholder="Name" required>
            <input name="last_name" type="text" placeholder="Surname" required>
            <input name="birth_date" type="date" placeholder="birthdate" required>
            <input name="image" type="file" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit">Add person</button>
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
