<!DOCTYPE html>
<html>
    <head>
        <title>Website_name: SIGN IN</title>
        <link rel="stylesheet" type="text/css" href="public\css\style.css">
        <script src="https://kit.fontawesome.com/89efed05c9.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
    </head>

    <body>
        <div class="body-container">
            <header>
                <div class = "logo">
                    <a href="dashboard"><img src="public\img\logo.svg"></a>
                </div>
                <div class="sign-up">
                   <a href="register">SIGN UP</a>
                </div>
            </header>
            <main>
                <div class="main-container">

                    <div class="info">
                        <h1>Sign in</h1><br>
                        <h2>Enter e-mail and password to your account</h2>
                    </div>

                    <div class="sing-in-container">
                        <form class="login" action="login" method="POST">
                            
                        <div class = "messages">
                            <?php if(isset($messages)){
                                 foreach ($messages as $message){
                                    echo $message;
                                }
                            }
                        
                            ?>
                        </div>

                            <label for="mail">E-mail</label>
                            <input name="email" type="email" id="mail">

                            <label for="password">Password</label>
                            <input name="password" type="password" id="password">

                            <button type="submit">Sign in</button>
                        </form>
                    </div>
                </div>
            </main>
            <footer>
            <nav>
                <ul class="nav-media">
                    <li id="tiktok"><a href="#"><i class="fa-brands fa-tiktok"></a></i></li>
                    <li id="insta"><a href="##"><i class="fa-brands fa-instagram"></a></i></li>
                    <li id="x"><a href="#"><i class="fa-brands fa-x-twitter"></a></i></li>
                    <li id="youtube"><a href="#"><i class="fa-brands fa-youtube"></a></i></li>
                    <li id="facebook"><a href="#"><i class="fa-brands fa-facebook"></a></i></li>
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