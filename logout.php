<?php

session_start();

unset($_SESSION['userId']);
setcookie('userId', '', -1, '/');

header('Location: ./login.php');
