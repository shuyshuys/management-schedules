<?php
require_once "auth.php";
logout();
header('Location: login');
exit();
