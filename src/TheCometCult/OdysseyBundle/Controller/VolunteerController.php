<?php

namespace TheCometCult\OdysseyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use TheCometCult\OdysseyBundle\Form\Type\VolunteerType;
use TheCometCult\OdysseyBundle\Document\Volunteer;
use TheCometCult\OdysseyBundle\VolunteerEvents;
use TheCometCult\OdysseyBundle\Event\VolunteerRegisteredEvent;

class VolunteerController extends Controller
{
    public function homeAction(Request $request)
    {
        $volunteer = new Volunteer();
        $volunteer->setStatus(Volunteer::STATUS_ADMITTED);
        $form = $this->createForm(new VolunteerType(), $volunteer);
        $form->handleRequest($request);

        if($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($volunteer);
            $dm->flush();
            $this->get('event_dispatcher')->dispatch(
                VolunteerEvents::EVENT_VOLUNTEER_REGISTERED,
                new VolunteerRegisteredEvent()
            );
            $this
                ->get('session')
                ->getFlashBag()
                ->add('notice', sprintf('%s successfully volunteered!', $volunteer->getEmail()));
        }

        $successRateCalculator = $this->get('the_comet_cult_odyssey.success_rate_calculator');
        $successRate = $successRateCalculator->calculateSuccessRate();
        $this
            ->get('session')
            ->getFlashBag()
            ->add('notice', sprintf('Our success rate is %s%%', $successRate));

        return $this->render('TheCometCultOdysseyBundle:Volunteer:home.html.twig', array('form' => $form->createView()));
    }
}
