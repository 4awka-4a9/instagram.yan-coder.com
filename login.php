<?php

require_once "core/init.php";

if (loggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {

    if (isset($_POST['submitButton'])) {

        $form_errors = array();
        $required_fields = array("email", "password", "username", "fullName");

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        $fields_to_check_length = array("fullName" => 3, "username" => 3, "password" => 6);
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

        $form_errors = array_merge($form_errors, check_email($_POST));

        $rules = [
            'email' => array('unique' => 'users'),
            'username' => array('unique' => 'users'),
            'password' => array('max' => 30),
        ];

        $account->check($_POST, $rules);

        if ($account->passed()) {

            if (empty($form_errors)) {

                $username = escape($_POST['username']);
                $fullName = escape($_POST['fullName']);
                $email = escape($_POST['email']);
                $password = escape($_POST['password']);

                $user_id = $account->register_user($username, $fullName, $email, $password);

                if ($user_id) {

                    session_regenerate_id();
                    $_SESSION['user_id'] = $user_id;

                    Redirect::to(url_for('index.php'));

                }

            }

        } else {
            $form_errors = array_merge($form_errors, $account->errors());
        }

    }

    if (empty($form_errors)) {

    }

}

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

            <?php

            if (!empty($form_errors)) {
                echo show_errors($form_errors);
            }

            ?>

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