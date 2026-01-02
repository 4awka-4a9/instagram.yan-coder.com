<?php

    require_once "core/init.php";
    $title = "Login | Instagram";
    $keywords = "Instagram, Share and capture world's moments, share, capture, share,home";
    require "shared/header.php";

?>

<section class="pageContainer">

        <main class="row">

            <div class="col-1">
                <div class="heroImg">

                </div>
            </div>

            <article class="col-2">

                <form action="<?= h($_SERVER['PHP_SELF']); ?>" method="POST" action="" class="form">

                    <div class="siteLogoContainer">
                        <img src="images/logo/instagram.png" alt="Instagram Logo">
                    </div>

                    <input type="text" placeholder="Email or username" class="form--input" name="email_username">

                    <div class="passwordContainer">
                        <input type="password" placeholder="Password" class="form--input" name="password" id="password">
                        <span class="show_hide_text cursor-pointer" id="show_hide_password">Show</span>
                    </div>

                    <button class="button cursor-pointer" type="submitButton">Log In</button>

                    <span class="separator">Or</span>

                    <a href="#" class="password_reset">Forgot password?</a>

                </form>

                <footer class="form--footer">

                    Don't have an account? <a href="register.php">Sing Up</a>

                </footer>

            </article>

        </main>

    </section>

    <script src="js/common.js"></script>

</body>
</html>