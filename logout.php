<?php

	session_start(); // Start The Session

	session_unset(); // Unset The Data

	session_destroy(); // Destory The Session
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
	header('Location: '.$previous);

	exit();