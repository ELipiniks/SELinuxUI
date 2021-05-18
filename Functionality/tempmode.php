<?php

use Commands\Linux;

require_once 'Commands/Linux.php';
$selinux = new Linux();
if (isset($_GET['tempMode'])) {
    $selinux->setenforce($_GET['tempMode']);
}
Header('Location:../main.php');