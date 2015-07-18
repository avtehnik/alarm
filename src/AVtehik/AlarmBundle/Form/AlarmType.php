<?php

namespace AVtehik\AlarmBundle\Form;

use AVtehik\AlarmBundle\Entity\Alarm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlarmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

//
        $builder
            ->add('time', 'datetime')
            ->add('days', 'choice', [
                'multiple'=>true,
                'choices' => [
                    Alarm::FRI => 'Fri',
                    Alarm::MON => 'MON',
                    Alarm::SAT => 'SAT',
                    Alarm::SUN => 'SUN',
                    Alarm::THU => 'THU',
                    Alarm::TUE => 'TUE',
                    Alarm::WED => 'WED'
                ]
            ])
            ->add('runOnce', 'choice', [
                'choices' => [true=>'yes', false=>'no']
            ])
            ->add('long', 'choice', [
                'choices' => [true=>'yes', false=>'no']
            ])
            ->add('enabled', 'choice', [
                'choices' => [true=>'yes', false=>'no']
            ])
            ->add('task')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AVtehik\AlarmBundle\Entity\Alarm'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appshed_slidebundle_hint';
    }

//$this->time = $time;
//$this->days = $days;
//$this->runOnce = $once;
//$this->long = $long;


}
