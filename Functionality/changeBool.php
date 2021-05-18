<?php

use Commands\Linux;

require_once 'Commands/Linux.php';
$selinux = new Linux();
if (isset($_GET['boolean']) and isset($_GET['state'])) {
    exec("sudo /var/www/html/Functionality/Scripts/changeBool.sh {$_GET['boolean']} {$_GET['state']}");
}
Header('Location:../boolean.php');