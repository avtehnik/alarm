<?php
/**
 * Created by PhpStorm.
 * User: vitaliy
 * Date: 7/18/15
 * Time: 10:13 PM
 */

namespace AVtehik\AlarmBundle\Command;

use AVtehik\AlarmBundle\Services\AlarmManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class ExecutorCommand extends Command
{


    private $alarmManager;

    /**
     * ExecutorCommand constructor.
     *
     * @param $alarmManager
     */
    public function __construct( AlarmManager $alarmManager)
    {
        parent::__construct();

        $this->alarmManager = $alarmManager;
    }


    protected function configure()
    {
        parent::configure();

        $this
            ->setName('home:alarm')
            ->setDescription('Ececute tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $alarms = $this->alarmManager->getAlarms();
        foreach ($alarms as $alarm) {
            if($this->alarmManager->check($alarm, )){
                exec($alarm->getAction());
            }
        }

        echo count($alarms);

    }

}
