<?php
require __DIR__ . '/../config/config.php';

//$_SESSION['userLoggedIn'] = false;
session_destroy();
header('Location: index.php');