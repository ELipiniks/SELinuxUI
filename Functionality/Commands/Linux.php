<?php


namespace Commands;


class Linux
{
    public function getUserList()
    {
        exec('sudo /var/www/html/Functionality/Scripts/linuxUsers.sh', $output);
        return $output;
    }

    public function setenforce($mode)
    {
        exec("sudo /var/www/html/Functionality/Scripts/setenforce.sh {$mode}");
    }

    public function readSelinuxConfig()
    {
        $handle = fopen("/etc/selinux/config", "r");
        $configContent = [];
        $counter = 0;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                $configContent[$counter] = $line;
                $counter++;
            }
            fclose($handle);
        }
        return array_values(array_filter($configContent));
    }

    public function writeSelinuxConfig($configContent)
    {
        $config = fopen("/etc/selinux/config", "w") or die("Neizdevās atvērt datni!");
        foreach ($configContent as $line) {
            fwrite($config, $line . "\r\n");
        }
        fclose($config);
    }

    public function getSELinuxTypes()
    {
        $configContent = $this->readSelinuxConfig();
        $count = count($configContent);
        $offset = 0;
        $typeArray = [];
        for ($i = 0; $i < $count; $i++) {
            if (preg_match("/SELINUX=/i", $configContent[$i]) and !preg_match("/#/i", $configContent[$i])) {
                $offset = $i;
            }
        }
        $index = 0;
        for ($i = $offset; $i < $count; $i++) {
            if (preg_match("/#/i", $configContent[$i]) and preg_match("/-/i", $configContent[$i])) {
                $fraction = preg_split('/[\s]+/', $configContent[$i]);
                $typeArray[$index] = $fraction[1];
                $index++;
            }
        }
        return $typeArray;
    }

    public function getCurrentSELinuxConfig()
    {
        $configContent = $this->readSelinuxConfig();

        $count = count($configContent);
        $configArray = [];
        for ($i = 0; $i < $count; $i++) {
            if (preg_match("/SELINUX=/i", $configContent[$i]) and !preg_match("/#/i", $configContent[$i])) {
                $configContent[$i] = str_replace('SELINUX=', '', $configContent[$i]);
                $configArray['mode'] = $configContent[$i];
            }
            if (preg_match("/SELINUXTYPE=/i", $configContent[$i]) and !preg_match("/#/i", $configContent[$i])) {
                $configContent[$i] = str_replace('SELINUXTYPE=', '', $configContent[$i]);
                $configArray['type'] = $configContent[$i];
            }
        }

        return $configArray;
    }

    public function setSELinuxMode($mode)
    {
        $configContent = $this->readSelinuxConfig();
        $count = count($configContent);
        for ($i = 0; $i < $count; $i++) {
            if (preg_match("/SELINUX=/i", $configContent[$i]) and !preg_match("/#/i", $configContent[$i])) {
                $configContent[$i] = "SELINUX={$mode}";
            }
        }
        $this->writeSelinuxConfig($configContent);
    }

    public function setSELinuxType($type)
    {
        $configContent = $this->readSelinuxConfig();
        $count = count($configContent);
        for ($i = 0; $i < $count; $i++) {
            if (preg_match("/SELINUXTYPE=/i", $configContent[$i]) and !preg_match("/#/i", $configContent[$i])) {
                $configContent[$i] = "SELINUXTYPE={$type}";
            }
        }
        $this->writeSelinuxConfig($configContent);
    }
}
