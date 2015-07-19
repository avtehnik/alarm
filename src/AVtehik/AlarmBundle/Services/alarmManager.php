<?php


namespace AVtehik\AlarmBundle\Services;

use AVtehik\AlarmBundle\Entity\Alarm;
use Symfony\Component\Validator\Constraints\DateTime;

class AlarmManager
{

    private $alarmsFolder = null;
    private $currentDate;
    const FILE_EXENSION = '.alarm';

    public function __construct($folder = null)
    {
        $this->alarmsFolder = $folder;
        $this->currentDate = new DateTime();
    }

    /**
     * @return Alarm[]
     */
    public function getAlarms()
    {

        $dir = opendir($this->alarmsFolder);

        $alarms = [];

        while (($file = readdir($dir)) !== false) {
            if ($file == '..' || $file == '.') {
                continue;
            }

            $id =  str_replace(self::FILE_EXENSION,'',$file);
            $alarm = $this->getAlarm($id);
            $alarms[$id] = $alarm;
        }

        return $alarms;
    }

    /**
     * @param Alarm $alarm
     *
     * @return string alarm file name
     */
    public function saveAlarm(Alarm $alarm)
    {
       return file_put_contents($this->fileName(time()), serialize($alarm));
    }

    /**
     * @param $id
     *
     * @return Alarm
     */
    public function getAlarm($id)
    {
        $alarm = unserialize(file_get_contents($this->fileName($id)));
        return $alarm;
    }

    public function deleteAlarm($id)
    {
        return unlink($this->fileName($id));
    }



    public function check( Alarm $alarm)
    {
        if ($alarm->getEnabled() && ($this->currentDate->format('H:i') == $this->getTime()->format('H:i'))) {
            if (count($alarm->getDays()) && !in_array($this->currentDate->format('D'), $alarm->getDays())) {
                return false;
            } else {
                if ($alarm->getRepeat()) {
                    $alarm->setEnabled(false);
                    $this->saveAlarm($alarm);
                }
                return true;
            }
        }

        return false;
    }



    private function fileName($id){
        return $this->alarmsFolder . '/' . $id . self::FILE_EXENSION;
    }

}

