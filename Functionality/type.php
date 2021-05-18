<?php

use Commands\Linux;

require_once 'Commands/Linux.php';
$selinux = new Linux();
if (isset($_GET['type'])) {
    $selinux->setSELinuxType($_GET['type']);
}
Header('Location:../main.php');