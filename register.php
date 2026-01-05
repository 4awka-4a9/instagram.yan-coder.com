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

        if ($account -> passed()) {

            if (empty($form_errors)) {

                $username = escape($_POST['username']);
                $fullName = escape($_POST['fullName']);
                $email = escape($_POST['email']);
                $password = escape($_POST['password']);

                $user_id = $account -> register_user($username, $fullName, $email, $password);

                if ($user_id) {

                    session_regenerate_id();
                    $_SESSION['user_id'] = $user_id;
                    
                    Redirect::to(url_for('index.php'));

                }

            }

        }
        else {
            $form_errors = array_merge($form_errors, $account -> errors());
        }

    }

    if (empty($form_errors)) {

    }

}

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

            <?php

            if (!empty($form_errors)) {
                echo show_errors($form_errors);
            }

            ?>

            <form action="<?= h($_SERVER['PHP_SELF']); ?>" method="POST" class="form">

                <div class="siteLogoContainer">
                    <img src="images/logo/instagram.png" alt="Instagram Logo">
                </div>

                <input type="email" placeholder="Email" class="form--input" name="email" autocomplete="off"
                    value="<?= escape(Input::get('email')); ?>">
                <input type="text" placeholder="Full Name" class="form--input" name="fullName" autocomplete="off"
                    value="<?= escape(Input::get('fullName')); ?>">
                <input type="text" placeholder="Username" class="form--input" name="username" autocomplete="off"
                    value="<?= escape(Input::get('username')); ?>">

                <div class="passwordContainer">
                    <input type="password" placeholder="Password" class="form--input" name="password" id="password"
                        autocomplete="off">
                    <span class="show_hide_text cursor-pointer" id="show_hide_password">Show</span>
                </div>

                <button class="button cursor-pointer" type="submitButton" name="submitButton">Register</button>

                <span style="font-size: 15px;">By signing up, you agree to our Terms, Privacy Policy and Cookies
                    Policy</span>

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