<?php

    $title = "Register | Instagram";
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

                <form action="">

                    <div class="siteLogoContainer">
                        <img src="/instagram_clone/images/logo/instagram.png" alt="Instagram Logo">
                    </div>

                    <input type="email" placeholder="Email" class="form--input" name="email">
                    <input type="text" placeholder="Full Name" class="form--input" name="full_name">
                    <input type="text" placeholder="Username" class="form--input" name="username">

                    <div class="passwordContainer">
                        <input type="password" placeholder="Password" class="form--input" name="password" id="password">
                        <span class="show_hide_text cursor-pointer" id="show_hide_password">Show</span>
                    </div>

                    <button class="button cursor-pointer" type="submitButton">Register</button>

                    <span style="font-size: 15px;">By signing up, you agree to our Terms, Privacy Policy and Cookies Policy</span>

                </form>

                <footer class="form--footer">

                    Have an account? <a href="login.php">Log In</a>

                </footer>

            </article>

        </main>

    </section>

    <script src="js/common.js"></script>

</body>
</html>