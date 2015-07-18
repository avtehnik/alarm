<?php


namespace AVtehik\AlarmBundle\Entity;

class Alarm implements \JsonSerializable{

    const SUN = 'Sun';
    const MON = 'Mon';
    const TUE = 'Tue';
    const WED = 'Wed';
    const THU = 'Thu';
    const FRI = 'Fri';
    const SAT = 'Sat';
    const FILE_EXENSION = '.alarm';
    const DAY_IN_SECONDS = 86400;

    private $time = null;
    private $days = [];
    private $runOnce = false;
    private $long = false;
    private $enabled = true;
    private $name = null;
    private $task = null;
    private $path = null;
    private $currentDate;

    function __construct() {
        $this->currentDate = new \DateTime();
    }

    function __wakeup(){
       // $this->time = new \DateTime();

    }

    public function getName() {
        if ($this->name == null) {
            $this->name = time();
        }
        return $this->name;
    }

    public function setName($name) {
        $this->name = str_replace(Alarm::FILE_EXENSION,'',$name);
    }

    public function getEnabled() {
        return $this->enabled;
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    public function getEnabledString() {
        return $this->enabled ? 'YES' : 'NO';
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime(\DateTime $time) {
        $this->time = $time;
    }

    public function getDays() {
        return $this->days;
    }

    public function setDays($days) {
        $this->days = $days;
    }

    public function getOnce() {
        return $this->runOnce;
    }

    public function getOnceString() {
        return $this->runOnce ? 'YES' : 'NO';
    }

    public function setOnce($once) {
        $this->runOnce = $once;
    }

    public function getLong() {
        return $this->long;
    }

    public function getLongString() {
        return $this->long ? 'YES' : 'NO';
    }

    public function setLong($long) {
        $this->long = $long;
    }

    public function getTask() {
        return $this->task;
    }

    public function setTask($task) {
        $this->task = $task;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function setCurrentDate(\DateTime $currentDate) {
        $this->currentDate = $currentDate;
    }

    public function check() {

        if (in_array($this->currentDate->format('D'), $this->days) && $this->currentDate->format('H:i') == $this->getTimeString() && $this->getEnabled()) {
            if ($this->getOnce()) {
                $this->setEnabled(false);
                $this->update();
            }
            return true;
        }
        return false;
    }

    public function update() {
        $this->store(pathinfo($this->getPath(), PATHINFO_DIRNAME));
    }

    public function getTimeString() {
        return $this->getTime()->format('H:i');
    }

    private function getTimeApi() {

        return array(
            'h'=>$this->getTime()->format('H'),
            'm'=>$this->getTime()->format('i')
        );
    }

    public function getDaysString() {
        $days = $this->getDays();
        return implode(',', $days);
    }

    public function store($path) {
        $name = $this->getName() . self::FILE_EXENSION;
        file_put_contents($path . DIRECTORY_SEPARATOR . $name, serialize($this));
        return $name;
    }

    /**
     * @param $path
     *
     * @return Alarm
     */
    public static function restore($path) {
        $alarm = unserialize(file_get_contents($path));
        $alarm->setPath($path);
        $alarm->setCurrentDate(new \DateTime());
        return $alarm;
    }

    public function lastToStart() {
        $this->currentDate->getTimestamp();

        $year = $this->currentDate->format('Y');
        $month = $this->currentDate->format('m');
        $day = $this->currentDate->format('d');

        $this->time->setDate($year, $month, $day);
        if ($this->time->getTimestamp() > $this->currentDate->getTimestamp()) {
            return $this->secondsToTime($this->time->getTimestamp() - $this->currentDate->getTimestamp());
        } else {
            return $this->secondsToTime(self::DAY_IN_SECONDS - ( $this->currentDate->getTimestamp() - $this->time->getTimestamp()));
        }
    }

    private function secondsToTime($seconds) {
        $second = (int) ($seconds) % 60;
        $minutes = (int) ($seconds / 60) % 60;
        $hours = (int) ($seconds / 60 / 60);

        return $hours . 'h ' . $minutes . 'm ' . $second . 's';
    }

    public function jsonSerialize() {
        return array(
            'id'=>  $this->getName(),
            'time'=>  $this->getTimeApi(),
            'days'=>  $this->getDays(),
            'enabled'=>  $this->getEnabled(),
            'runOnce'=>  $this->getOnce(),
            'longPlay'=>  $this->getLong(),
            'task'=>  $this->getTask(),
        );
    }

    /**
     * @return boolean
     */
    public function isRunOnce()
    {
        return $this->runOnce;
    }

    /**
     * @param boolean $runOnce
     */
    public function setRunOnce($runOnce)
    {
        $this->runOnce = $runOnce;
    }

}

