<?php

session_start();

//ends the session
session_destroy();

//redirects to the start page after logging out
header("Location: start.php");

?>