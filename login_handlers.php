<?php

require_once "core/init.php";

if (loggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {

    if (isset($_POST['submitButton'])) {

        $form_errors = array();
        $required_fields = array("email_username", "password");

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        $email_username = escape($_POST['email_username']);
        $password = escape($_POST['password']);

        $user_id = $account->login_user($email_username, $password);

        if ($account->passed()) {

            if (empty($form_errors)) {

                session_regenerate_id();
                $_SESSION['user_id'] = $user_id;

                Redirect::to(url_for('index.php'));

            }

        } else {
            $form_errors = array_merge($form_errors, $account->errors());
        }

    }

}

$title = "Login | Instagram";
$keywords = "Instagram, Share and capture world's moments, share, capture, share,home";

?>