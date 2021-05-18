<?php
exec("sudo /var/www/html/Functionality/Scripts/fixfiles.sh", $output);
header("Location: ../main.php");