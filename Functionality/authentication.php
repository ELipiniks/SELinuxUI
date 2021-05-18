<?php

session_start();

$_POST['password'] = trim($_POST['password']);

$config = parse_ini_file('config.ini');

if (password_verify($_POST['password'], $config['hash'])) {


    session_regenerate_id();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $_POST['username'];
    echo 'Izdevas';
    header('Location:../main.php');
} else {
    echo 'Nepareiza parole vai lietotājvārds';
}
