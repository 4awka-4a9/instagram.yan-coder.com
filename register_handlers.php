<?php

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

$title = "Register | Instagram";
$keywords = "Instagram, Share and capture world's moments, share, capture, share,home";

?>