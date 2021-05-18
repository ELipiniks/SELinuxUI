<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

use Commands\Ausearch;
use Commands\Seinfo;
use Commands\Semanage;
use Commands\Sestatus;
use Commands\Linux;

require_once 'Commands/Sestatus.php';
require_once 'Commands/Semanage.php';
include 'Commands/Ausearch.php';
require_once 'Commands/Linux.php';
require_once 'Commands/Seinfo.php';
function displayLogData()
{
    $ausearch = new Ausearch();
    $data = $ausearch->getAVCLogs();
    $count = count($data['Comm']);
    for ($i = 0; $i < $count; $i++) {
        echo "
        <tr>
        <td>{$data['audit'][$i]}</td>
        <td>{$data['DeniedAction'][$i]}</td>
        <td>{$data['Comm'][$i]}</td>
        <td>{$data['scontext'][$i]}</td>
        <td>{$data['tcontext'][$i]}</td>
        </tr>
        ";
    }
}

function displayMappedUsers()
{
    $semanage = new Semanage();
    $data = $semanage->getUserList();
    $count = count($data['LinuxUser']);
    for ($i = 1; $i < $count; $i++) {
        echo "
        <tr>
        <td>{$data['LinuxUser'][$i]}</td>
        <td>{$data['SELinuxUser'][$i]}</td>
        <td>{$data['Range'][$i]}</td>
        </tr>
        ";
    }
}

function getBoolOptions($option)
{
    if ($option == 'on') {
        echo "
            <option value=\"on\">on</option>
            <option value=\"off\">off</option>
        ";
    }
    if ($option == 'off') {
        echo "
            <option value=\"off\">off</option>
            <option value=\"on\">on</option>
        ";
    }
}

function displayBooleans()
{
    $semanage = new Semanage();
    $data = $semanage->getBooleanList();
    $count = count($data['boolean']);
    for ($i = 2; $i < $count; $i++) {
        echo "
            <form action=\"/Functionality/changeBool.php\">
                    <td><input type=\"text\" name=\"boolean\" value=\"{$data['boolean'][$i]}\" readonly /></td>
                    <td>
                        <select name=\"state\">";
        if ($data['state'][$i] == 'on') {
            echo "
            <option value=\"on\">on</option>
            <option value=\"off\">off</option>
        ";
        }
        if ($data['state'][$i] == 'off') {
            echo "
            <option value=\"off\">off</option>
            <option value=\"on\">on</option>
        ";
        }
        echo "</select>
                    </td>
                    <td>{$data['description'][$i]}</td>
                    <td><input type=\"submit\" value=\"SAGLABĀT\"></td>
                    </tr>
                </form>
        ";
    }
}

function displayModeOptions()
{
    $config = new Linux();
    $data = $config->getCurrentSELinuxConfig();
    if ($data['mode'] == 'disabled') {
        echo "
        <option value='disabled'>Atslēgts</option>
        <option value='permissive'>Atļaujošs</option>
        <option value='enforcing'>Izpildošs</option>

        ";
    }
    if ($data['mode'] == 'permissive') {
        echo "
        <option value='permissive'>Atļaujošs</option>
        <option value='disabled'>Atslēgts</option>
        <option value='enforcing'>Izpildošs</option>

        ";
    }
    if ($data['mode'] == 'enforcing') {
        echo "
        <option value='enforcing'>Izpildošs</option>
        <option value='disabled'>Atslēgts</option>
        <option value='permissive'>Atļaujošs</option>

        ";
    }
}

function displayTempModeOptions()
{
    $sestatus = new Sestatus();
    $data = $sestatus->getValue('Current mode');

    if ($data == 'disabled') {
        echo "
        <option value='disabled'>Atslēgts</option>
        <option value='permissive'>Atļaujošs</option>
        <option value='enforcing'>Izpildošs</option>

        ";
    }
    if ($data == 'permissive') {
        echo "
        <option value='permissive'>Atļaujošs</option>
        <option value='disabled'>Atslēgts</option>
        <option value='enforcing'>Izpildošs</option>

        ";
    }
    if ($data == 'enforcing') {
        echo "
        <option value='enforcing'>Izpildošs</option>
        <option value='disabled'>Atslēgts</option>
        <option value='permissive'>Atļaujošs</option>

        ";
    }
}

function displayTypeOptions()
{
    $config = new Linux();
    $currentType = $config->getCurrentSELinuxConfig();
    $types = $config->getSELinuxTypes();
    echo "
        <option value='{$currentType['type']}'>{$currentType['type']}</option>
        ";
    foreach ($types as $type) {
        if ($type == $currentType['type']) {
            continue;
        }
        echo "
        <option value='{$type}'>{$type}</option>
        ";
    }
}

function displayWarnings()
{
    $config = new Linux();
    $currentMode = $config->getCurrentSELinuxConfig();
    $sestatus = new Sestatus();
    $tempMode = $sestatus->getValue('Current mode');

    if (($currentMode['mode'] == 'permissive') or ($tempMode == 'permissive')) {
        echo "<b>BRIDINAJUMS:</b>  SELinux darbojas atļaujošajā režīmā, ieteicams validēt virsrakstus pirms pārslēgties uz izpildošo režīmu!";
    }

    exec("sudo /var/www/html/Functionality/Scripts/grep.sh", $output);
    if (isset($output)) {
        echo "</br> <b>BRIDINAJUMS:</b> Sāknēšanās procesā SELinux norobežoja dažus procesus, nepieciešama pārbaude audita žurnālā!";
    }

}

function selinuxStatus()
{
    $sestatus = new Sestatus();
    $tempMode = $sestatus->getValue('SELinux status');
    if ($tempMode == 'enabled') {
        echo "AKTĪVS";
    }
    if ($tempMode == 'disabled') {
        echo "NEAKTĪVS";
    }
}

function displayLinuxUsers()
{
    $sestatus = new Linux();
    $data = $sestatus->getUserList();
    foreach ($data as $user) {
        if ($user == 'apache') {
            continue;
        } else if ($user == 'root') {
            continue;
        }
        echo "
        <option value='{$user}'>{$user}</option>
        ";
    }
}

function displaySelinuxUsers()
{
    $sestatus = new Seinfo();
    $data = $sestatus->getIdentities();
    foreach ($data as $user) {
        echo "
        <option value='{$user}'>{$user}</option>
        ";
    }

}
