<?php

namespace TheCometCult\OdysseyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use TheCometCult\OdysseyBundle\Form\Type\VolunteerType;
use TheCometCult\OdysseyBundle\Document\Volunteer;

class VolunteerController extends Controller
{
    public function homeAction(Request $request)
    {
    	$volunteer = new Volunteer();
    	$form = $this->createForm(new VolunteerType(), $volunteer);
    	$form->handleRequest($request);

    	if($form->isValid()) {
    		$dm = $this->get('doctrine_mongodb')->getManager();
    		$dm->persist($volunteer);
    		$dm->flush();

    		$this->get('session')->getFlashBag()->add('notice', sprintf('%s successfully volunteered!', $volunteer->getEmail()));
    	}

        return $this->render('TheCometCultOdysseyBundle:Volunteer:home.html.twig', array('form' => $form->createView()));
    }
}
