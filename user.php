<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include 'Functionality/FunctionHandler.php'; ?>
<!DOCTYPE html>
<html lang="lv" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <!-- Izvēlnes animācijas skripts -->
    <script type="text/javascript" src="/js/openNav.js"></script>
    <title>SELinux UI</title>
</head>

<body>
<!-- Satura apvalks -->
<div class="content-wrapper">
    <!-- Sli -->
    <nav id="sideNavigation">
        <!-- X krusts, lai aizvērtu navigāciju -->
        <a href="javascript:void(0)" id="close" class="closebtn" onclick="closeNav()">&times;</a>
        <h3>SELINUX</h3>
        <div class="sideNavigation-line"></div>
        <h4>ADAPTĀCIJAS SASKARNE</h4>
        <!-- Navigācijā esošās saites -->
        <a href="main.php">SĀKUMS</a>
        <a href="boolean.php">BŪLI</a>
        <a href="user.php">LIETOTĀJI</a>
        <a href="log.php">ŽURNĀLS</a>
    </nav>
    <header>
        <!-- Navigācijas galvene -->
        <div class="header-menu">
            <!-- Poga, lai atvērtu navigāciju -->
            <span onclick="openNav()">&#9776; SISTĒMAS LIETOTĀJI</span>
            <div class="header-profile">
                <a href="/Functionality/logout.php">Izlogoties</a>
            </div>
        </div>
    </header>
    <main>

        <div class="user-table">
            <form action="/Functionality/addUser.php">
                <label>KARTĒT LINUX LIETOTĀJU:</label>
                <select name="User">
                    <option value="" disabled selected>Linux lietotājs</option>
                    <?php displayLinuxUsers() ?>
                </select>
                <select name="Identity">
                    <option value="" disabled selected>SELinux identitāte</option>
                    <?php displaySelinuxUsers() ?>
                </select>
                <input type="submit" value="SAGLABĀT">
            </form>

            <table>
                <tr>
                    <th style="width:30%;">LIETOTĀJVĀRDS</th>
                    <th style="width:30%;">SELINUX IDENTITĀTE</th>
                    <th style="width:30%;">DL/DK DIAPAZONS</th>
                </tr>
                <?php displayMappedUsers() ?>
            </table>
        </div>

    </main>
</div>
</body>

</html>
