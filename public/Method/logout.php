<?php
echo "Here";
session_start();

unset($_SESSION['user']);
unset($_SESSION['admin']);
unset($_SESSION['id']);

header('Location: ../index.php');
exit();