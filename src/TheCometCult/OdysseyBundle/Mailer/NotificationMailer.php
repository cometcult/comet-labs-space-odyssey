<?php

namespace TheCometCult\OdysseyBundle\Mailer;

use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use TheCometCult\OdysseyBundle\Document\Crew;

/**
 * NotificationMailer
 */
class NotificationMailer implements NotificationMailerInterface
{
    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param MessageFactory $messageFactory
     */
    public function setMessageFactory(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        $subject = $this->extractMessageSubject($renderedTemplate);
        $body = $this->extractMessageBody($renderedTemplate);
        $message = $this->messageFactory->create($subject, $body, $toEmail, $fromEmail);
        $this->mailer->send($message);
    }

    /**
     * @param Crew $crew
     */
    public function sendPackingInstructionsToCrewMembers(Crew $crew)
    {
        $packingInstructionsTemplate = $this->parameters['crew.packing_instructions.template'];
        $renderedTemplate = $this->templating->render($packingInstructionsTemplate);
        $recipients = $this->extractRecipients($crew);
        $fromEmail = $this->parameters['from_email'];
        foreach ($recipients as $recipient) {
            $this->sendEmailMessage($renderedTemplate, $fromEmail, $recipient);
        }
    }

    /**
     * @param Crew $crew
     */
    public function extractRecipients(Crew $crew)
    {
        $recipients = array();
        $volunteers = $crew->getVolunteers();
        foreach ($volunteers as $volunteer) {
            $email = $volunteer->getEmail();
            array_push($recipients, $email);
        }

        return $recipients;
    }

    /**
     * @param string $renderedTemplate
     *
     * @return string
     */
    public function extractMessageSubject($renderedTemplate)
    {
        $renderedLines = explode("\n", trim($renderedTemplate));

        return $renderedLines[0];
    }

    /**
     * @param string $renderedTemplate
     *
     * @return string
     */
    public function extractMessageBody($renderedTemplate)
    {
        $renderedLines = explode("\n", trim($renderedTemplate));

        return implode("\n", array_slice($renderedLines, 1));
    }
}
