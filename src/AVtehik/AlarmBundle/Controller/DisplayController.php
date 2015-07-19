<?php

namespace AVtehik\AlarmBundle\Controller;

use AVtehik\AlarmBundle\Entity\Alarm;
use AVtehik\AlarmBundle\Form\AlarmType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints\DateTime;


class DisplayController extends Controller
{
    /**
     * @Route("/",name="alarms_list")
     * @Template()
     */
    public function indexAction()
    {
        $alarms = $this->get('a_vtehik_alarm.alarm_manager')->getAlarms();

        return ['alarms' => $alarms];
    }

    /**
     * @Route("/add", name="add_alarm")
     * @Template()
     */
    public function addAction()
    {
        $alarm  = new Alarm();
        $alarm->setTime(new \DateTime());
        $form  = $this->createForm(new AlarmType(), $alarm, [
            'action' => $this->generateUrl('save_alarm', ['id' => 'new']),
            'method' => 'POST',
        ]);
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/edit/{id}", name="edit_alarm")
     * @Template()
     */
    public function editAction($id)
    {
        $alarm = $this->get('a_vtehik_alarm.alarm_manager')->getAlarm($id);
        $form  = $this->createForm(new AlarmType(), $alarm, [
            'action' => $this->generateUrl('save_alarm', ['id' => $id]),
            'method' => 'POST',
        ]);
        return ['form' => $form->createView(), 'deleteForm'=>$this->createDeleteForm($id)];
    }


    /**
     * @Route("/save/{id}", name="save_alarm")
     * @Template()
     * @Method("POST")
     */
    public function saveAction($id)
    {

        $request = $this->getRequest();

        $manager = $this->get('a_vtehik_alarm.alarm_manager');

        if ($id == 'new') {
            $alarm = new Alarm();
        } else {
            $alarm = $manager->getAlarm($id);
        }
        $form = $this->createForm(new AlarmType(), $alarm);

        if ($request->getMethod() == "POST") {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager->saveAlarm($alarm);
                return $this->redirect($this->generateUrl('alarms_list'));
            }
        }

        return ['form' => $form->createView()];
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('delete_alarm', ['id' => $id]))
                    ->setMethod('DELETE')
                    ->add('submit', 'submit', ['label' => 'Delete'])
                    ->getForm()
                    ->createView();
    }


    /**
     * @Route("/delete/{id}", name="delete_alarm")
     * @Template()
     * @Method("DELETE")
     */

    public function deleteAction($id)
    {
       $this->get('a_vtehik_alarm.alarm_manager')->deleteAlarm($id);
       return $this->redirect($this->generateUrl('alarms_list'));

    }


}
