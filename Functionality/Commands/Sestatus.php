<?php


namespace Commands;

class Sestatus
{

    private function getAttributeValue($outputToSplit)
    {
        $outputArray = explode(":", $outputToSplit);
        return preg_replace('/\s+/', '', $outputArray[1]);
    }

    public function getValue($parameter)
    {
        exec("sudo /var/www/html/Functionality/Scripts/sestatus.sh", $output);


        switch ($parameter) {
            /*
             * SELinux sta netiek veikts isset, jo 0.indekss vienmer attelosies, atgriezot
             * selinus darbibas rezimu, respektivi, kad SELinux izslegts, tad 0. indekss paradisies,
             * bet parejie ne.
             */
            case "SELinux status":
                return $this->getAttributeValue($output[0]);

            case "SELinuxfs mount":
                if (isset($output[1])) {
                    return $this->getAttributeValue($output[1]);
                } else {
                    return null;
                }

            case "SELinux root directory":
                if (isset($output[2])) {
                    return $this->getAttributeValue($output[2]);
                } else {
                    return null;
                }

            case "Loaded policy name":
                if (isset($output[3])) {
                    return $this->getAttributeValue($output[3]);
                } else {
                    return null;
                }

            case "Current mode":
                if (isset($output[4])) {
                    return $this->getAttributeValue($output[4]);
                } else {
                    return null;
                }

            case "Mode from config file":
                if (isset($output[5])) {
                    return $this->getAttributeValue($output[5]);
                } else {
                    return null;
                }

            case "Policy MLS status":
                if (isset($output[6])) {
                    return $this->getAttributeValue($output[6]);
                } else {
                    return null;
                }

            case "Policy deny_unknown status":
                if (isset($output[7])) {
                    return $this->getAttributeValue($output[7]);
                } else {
                    return null;
                }

            case "Memory protection checking":
                if (isset($output[8])) {
                    return $this->getAttributeValue($output[8]);
                } else {
                    return null;
                }

            case "Max kernel policy version":
                if (isset($output[9])) {
                    return $this->getAttributeValue($output[9]);
                } else {
                    return null;
                }

            default:
                return null;
        }
    }
}
