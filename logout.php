<?php

require_once "core/init.php";

log_out_user();

if (!loggedIn()) {
    Redirect::to('login.php');
}

?>