<?php

// session_start();

echo 'home';

echo 'userid:' . $_SESSION['userId'];

echo '<pre>';
print_r($_SESSION['userInfo']);
echo '</pre>';