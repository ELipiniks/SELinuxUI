<?php


namespace Commands;


class Semanage
{
    public function getUserList()
    {
        exec("sudo /var/www/html/Functionality/Scripts/sc.sh", $output);
        $output = array_values(array_filter($output));
        $outputCount = count($output);
        $outputData = [];
        for ($i = 1; $i < $outputCount; $i++) {
            $fraction = preg_split('/[\s]+/', $output[$i]);
            $outputData['LinuxUser'][$i] = $fraction[0];
            $outputData['SELinuxUser'][$i] = $fraction[1];
            $outputData['Range'][$i] = $fraction[2];
        }
        return $outputData;
    }

    public function getBooleanList()
    {
        exec("sudo /var/www/html/Functionality/Scripts/seBoolean.sh", $output);
        $outputCount = count($output);
        $boolDataArray = [];
        for ($i = 2; $i < $outputCount; $i++) {
            $fraction = preg_split('/[\s]+/', $output[$i]);
            $boolDataArray['boolean'][$i] = $fraction[0];
            $fraction[1] = str_replace('(', "", $fraction[1]);
            $boolDataArray['state'][$i] = $fraction[1];
            $wordCount = count($fraction);
            $string = "";
            for ($j = 4; $j < $wordCount; $j++) {
                $string .= $fraction[$j] . " ";
            }
            $boolDataArray['description'][$i] = $string;
        }
        return $boolDataArray;
    }


}
