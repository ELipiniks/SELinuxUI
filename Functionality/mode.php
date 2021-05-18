<?php

use Commands\Linux;

require_once 'Commands/Linux.php';
$selinux = new Linux();
if (isset($_GET['mode'])) {
    $selinux->setSELinuxMode($_GET['mode']);
}
Header('Location:../main.php');