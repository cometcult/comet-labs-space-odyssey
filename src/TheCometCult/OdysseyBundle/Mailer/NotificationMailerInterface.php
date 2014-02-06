<?php

namespace TheCometCult\OdysseyBundle\Mailer;

use TheCometCult\OdysseyBundle\Document\Crew;

interface NotificationMailerInterface
{
    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail);

    /**
     * @param Crew $crew
     */
    public function sendPackingInstructionsToCrewMembers(Crew $crew);

    /**
     * @param Crew $crew
     */
    public function extractRecipients(Crew $crew);

    /**
     * @param string $renderedTemplate
     *
     * @return string
     */
    public function extractMessageSubject($renderedTemplate);

    /**
     * @param string $renderedTemplate
     *
     * @return string
     */
    public function extractMessageBody($renderedTemplate);
}
