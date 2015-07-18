<?php


namespace AVtehik\AlarmBundle\Services;

use AVtehik\AlarmBundle\Entity\Alarm;

class AlarmManager
{

    var $alarmsFolder = null;

    public function __construct($folder = null)
    {
        if ($folder) {
            $this->alarmsFolder = $folder;
        } else {
            $this->alarmsFolder = __DIR__ . DIRECTORY_SEPARATOR . 'alarms';
        }
    }

    public function getAlarms()
    {

        $dir = opendir($this->alarmsFolder);

        $alarms = [];

        while (($file = readdir($dir)) !== false) {
            if ($file == '..' || $file == '.') {
                continue;
            }

            $alarm = Alarm::restore($this->alarmsFolder . '/' . $file);
            $alarm->setName($file);

            $alarms[] = $alarm;
        }

        return $alarms;
    }

    public function saveAlarm(Alarm $alarm)
    {
        $alarm->store($this->alarmsFolder);
    }

    public function getAlarm($id)
    {
        $alarm = Alarm::restore($this->alarmsFolder . '/' . $id . Alarm::FILE_EXENSION);
        $alarm->setName($id);
        return $alarm;
    }

    public function deleteAlarm($id)
    {
       return unlink($this->alarmsFolder . '/' . $id . Alarm::FILE_EXENSION);
    }


}

