<?php

namespace Commands;

class Ausearch
{
    public function getAVCLogs()
    {
        exec("sudo /var/www/html/Functionality/Scripts/ausearch.sh", $output);
        $logCount = count($output);
        $avcArray = [];
        $avcDataArray = [];
        $index = 0;
        // Iterēt cauri masīvam un izgūt visas AVC vērtības
        for ($i = 0; $i < $logCount; $i++) {
            if (strpos($output[$i], 'type=AVC') !== false) {
                $avcArray[$index] = $output[$i];
                $index++;
            }
        }
        for ($i = 0; $i < $index; $i++) {
            $result = preg_split('/[{}]+/', $avcArray[$i]);
            $avcDataArray['DeniedAction'][$i] = str_replace(' ', '', $result[1]);
            $fraction = preg_split('/[\s]+/', $avcArray[$i]);
            foreach ($fraction as $frac) {
                if (strpos($frac, 'comm=') !== false) {
                    $openstrpos = strpos($frac, "\"");
                    $closestrpos = strpos($frac, "\"");
                    $finalstr = substr($frac, $openstrpos + 1, $closestrpos - $openstrpos - 1);
                    $avcDataArray['Comm'][$i] = $finalstr;
                }
                if (strpos($frac, 'scontext=') !== false) {
                    $avcDataArray['scontext'][$i] = str_replace("scontext=", "", $frac);
                }
                if (strpos($frac, 'tcontext=') !== false) {
                    $avcDataArray['tcontext'][$i] = str_replace("tcontext=", "", $frac);
                }
                if (strpos($frac, 'msg=audit') !== false) {
                    $openstrpos = strpos($frac, "(");
                    $closestrpos = strpos($frac, ")");
                    $finalstr = substr($frac, $openstrpos + 1, $closestrpos - $openstrpos - 1);
                    $avcDataArray['audit'][$i] = $finalstr;
                }
            }
        }
        return $avcDataArray;

    }
}
