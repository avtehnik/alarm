<?php


namespace AVtehik\AlarmBundle\Entity;

class Alarm implements \JsonSerializable
{

    const SUN = 'Sun';
    const MON = 'Mon';
    const TUE = 'Tue';
    const WED = 'Wed';
    const THU = 'Thu';
    const FRI = 'Fri';
    const SAT = 'Sat';

    private $id;
    private $time = null;
    private $days = [];
    private $repeat = false;
    private $long = false;
    private $enabled = true;
    private $name = null;
    private $action = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function jsonSerialize()
    {
        return array(
            'id'=> $this->getId(),
            'name'       => $this->getName(),
            'time'     => $this->getTime()->format('H:i'),
            'days'     => $this->getDays(),
            'enabled'  => $this->getEnabled(),
            'runOnce'  => $this->getRepeat(),
            'longPlay' => $this->getLong(),
            'action'     => $this->getAction(),
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime(\DateTime $time)
    {
        $this->time = $time;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function setDays($days)
    {
        $this->days = $days;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getRepeat()
    {
        return $this->repeat;
    }

    /**
     * @return boolean
     */
    public function isRepeat()
    {
        return $this->repeat;
    }

    public function setRepeat($once)
    {
        $this->repeat = $once;
    }

    public function getLong()
    {
        return $this->long;
    }

    public function setLong($long)
    {
        $this->long = $long;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }
}

