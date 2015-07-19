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

//osascript -e 'display notification "Lorem ipsum dolor sit amet" with title "Title"'
        $builder
            ->add('time', 'time', ['label' => 'Час'])
            ->add('name', 'text', ['label' => 'Назва'])
            ->add('days', 'choice', [
                'label'    => 'Дні',
                'multiple' => true,
                'required' => false,
                'expanded' => true,
                'choices'  => [
                    Alarm::MON => 'Понеділок',
                    Alarm::TUE => 'Вівторок',
                    Alarm::WED => 'Середа',
                    Alarm::THU => 'Четвер',
                    Alarm::FRI => 'Пятниця',
                    Alarm::SAT => 'Субота',
                    Alarm::SUN => 'Неділя'
                ]
            ])
            ->add('repeat', 'choice', [
                'expanded' => true,
                'label'    => 'Повтор',
                'choices'  => [true => 'Так', false => 'Ні']
            ])
            ->add('long', 'choice', [
                'expanded' => true,
                'choices'  => [true => 'Так', false => 'Ні']
            ])
            ->add('enabled', 'choice', [
                'expanded' => true,
                'choices'  => [true => 'Так', false => 'Ні']
            ])
            ->add('action');
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
}
