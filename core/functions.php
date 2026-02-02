<?php

function h($string = "")
{
    return htmlspecialchars($string);
}

function url_for($script)
{
    return WWW_ROOT . $script;
}

function loggedIn()
{

    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }

}

function escape($string)
{
    return htmlspecialchars("$string", ENT_QUOTES);
}

function check_empty_fields($required_fields)
{

    $form_errors = array();

    foreach ($required_fields as $name_of_field) {

        if (!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL) {
            $form_errors[] = $name_of_field . " is required field.";
        }

    }

    return $form_errors;

}

function check_min_length($fields_to_check_length)
{

    $form_errors = array();

    foreach ($fields_to_check_length as $name_of_field => $minimum_lenght) {

        if (strlen(trim($_POST[$name_of_field])) < $minimum_lenght) {
            $form_errors[] = $name_of_field . " is too short, must be {$minimum_lenght} characters long.";
        }

    }

    return $form_errors;

}

function check_email($data)
{

    $form_errors = array();
    $key = "email";

    if (array_key_exists($key, $data)) {

        if ($_POST[$key] != null) {

            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            if (!filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
                $form_errors[] = $key . " is not a valid email address.";
            }

        }

    }

    return $form_errors;

}

function show_errors($form_errors_array)
{

    $errors = "<ul class='form_errors'>";

    foreach ($form_errors_array as $the_error) {
        $errors .= "<li>{$the_error}</li>";
    }

    $errors .= "</ul>";

    return $errors;

}

function log_out_user()
{

    unset($_SESSION['user_id']);
    $_SESSION = array();

    session_destroy();

    return true;

}

function nameShortener($name, $limit)
{

    if (strlen($name) >= $limit) {
        return substr($name, 0, intval($limit) - 2) . "..";
    }
    else if (strlen($name) < $limit) {
        return $name;
    }

}