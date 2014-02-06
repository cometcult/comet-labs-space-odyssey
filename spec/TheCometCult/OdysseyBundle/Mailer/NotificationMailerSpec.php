<?php

namespace spec\TheCometCult\OdysseyBundle\Mailer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Doctrine\Common\Collections\ArrayCollection;

class NotificationMailerSpec extends ObjectBehavior
{
    /**
     * @param Swift_Mailer $mailer
     * @param TheCometCult\OdysseyBundle\Mailer\MessageFactory $messageFactory
     * @param Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    function let($mailer, $messageFactory, $templating)
    {
        $parameters = array(
            'from_email' => 'no-reply@test.com',
            'crew.packing_instructions.template' => null
        );
        $this->beConstructedWith($mailer);
        $this->setMessageFactory($messageFactory);
        $this->setParameters($parameters);
        $this->setTemplating($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Mailer\NotificationMailer');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Document\Crew $crew
     * @param TheCometCult\OdysseyBundle\Mailer\MessageFactory $messageFactory
     * @param Swift_Message $message
     * @param Swift_Mailer $mailer
     * @param Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer1
     */
    function it_should_send_packing_instructions_to_crew_members(
        $crew,
        $messageFactory,
        $message,
        $mailer,
        $templating,
        $volunteer1
    )
    {
        $mailer->send($message)->shouldBeCalled();
        $crew->getVolunteers()->shouldBeCalled()->willReturn(new ArrayCollection(array($volunteer1)));
        $templating->render(Argument::any())->shouldBeCalled()->willReturn("Subject\nBody");
        $messageFactory->create(
            'Subject',
            'Body',
            Argument::any(),
            'no-reply@test.com'
        )->willReturn($message);
        $this->sendPackingInstructionsToCrewMembers($crew)->shouldReturn(null);
    }

    /**
     * @param TheCometCult\OdysseyBundle\Mailer\MessageFactory $messageFactory
     * @param Swift_Message $message
     * @param Swift_Mailer $mailer
     */
    function it_should_send_email_message($messageFactory, $message, $mailer)
    {
        $mailer->send($message)->shouldBeCalled();
        $renderedTemplate = "Subject\nBody";
        $messageFactory->create(
            'Subject',
            'Body',
            'volunteer1@test.com',
            'no-reply@test.com'
        )->shouldBeCalled()->willReturn($message);
        $this->sendEmailMessage(
            $renderedTemplate,
            'no-reply@test.com',
            'volunteer1@test.com'
        )->shouldReturn(null);
    }

    /**
     * @param TheCometCult\OdysseyBundle\Document\Crew $crew
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer1
     */
    function it_should_extract_recipients($crew, $volunteer1)
    {
        $volunteer1->getEmail()->willReturn('volunteer1@test.com');
        $volunteers = new ArrayCollection(array($volunteer1));
        $crew->getVolunteers()->willReturn($volunteers);
        $this->extractRecipients($crew)->shouldBeArray();
    }

    function it_should_extract_message_subject()
    {
        $renderedTemplate = "Subject\nBody";
        $this->extractMessageSubject($renderedTemplate)->shouldReturn('Subject');
    }

    function it_should_extract_message_body()
    {
        $renderedTemplate = "Subject\nBody";
        $this->extractMessageBody($renderedTemplate)->shouldReturn('Body');
    }
}
