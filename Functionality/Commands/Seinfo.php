<?php


namespace Commands;

class Seinfo
{
    public function getIdentities()
    {
        exec('sudo /var/www/html/Functionality/Scripts/seinfo.sh', $output);
        unset($output[1]);
        $output = array_values(array_filter($output));
        $count = count($output);
        for ($i = 0; $i < $count; $i++) {
            $output[$i] = trim($output[$i]);
        }
        return $output;
    }
}