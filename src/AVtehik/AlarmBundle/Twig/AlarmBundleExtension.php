<?php

namespace AVtehik\AlarmBundle\Twig;

use AVtehik\AlarmBundle\Entity\Alarm;
use Symfony\Component\Validator\Constraints\DateTime;

class AlarmBundleExtension extends \Twig_Extension
{

    const DAY_IN_SECONDS = 86400;

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('timeLeft', [$this, 'timeLeft'])
        ];
    }

    public function timeLeft(\DateTime $time)
    {

        $currentDate = new \DateTime();
        $year        = $currentDate->format('Y');
        $month       = $currentDate->format('m');
        $day         = $currentDate->format('d');

        $time->setDate($year, $month, $day);
        if ($time->getTimestamp() > $currentDate->getTimestamp()) {
            return $this->secondsToTime($time->getTimestamp() - $currentDate->getTimestamp());
        } else {
            return $this->secondsToTime(self::DAY_IN_SECONDS - ($currentDate->getTimestamp() - $time->getTimestamp()));
        }

    }


    public function getName()
    {
        return 'alarm_extension';
    }

    private function secondsToTime($seconds)
    {
        $second  = (int) ($seconds) % 60;
        $minutes = (int) ($seconds / 60) % 60;
        $hours   = (int) ($seconds / 60 / 60);

        return $hours . ':' . $minutes . ':' . $second . '';
    }


}
