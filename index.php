<?php

require_once "core/init.php";

if (!loggedIn()) {
    Redirect::to('login');
}

$user_id = $_SESSION['user_id'];