<?php
if (isset($_GET['User']) and isset($_GET['Identity'])) {
    exec("sudo /var/www/html/Functionality/Scripts/addUser.sh {$_GET['Identity']} {$_GET['User']}", $output);
}
Header("Location:../user.php");