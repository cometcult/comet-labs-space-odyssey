<?php

namespace TheCometCult\OdysseyBundle\Mailer;

use Swift_Message;

/**
 * MessageFactory
 */
class MessageFactory
{
    /**
     * @param string $subject
     * @param string $body
     * @param string $toEmail
     * @param array  $fromEmail
     *
     * @return Swift_Message
     */
    public function create($subject, $body, $toEmail, $fromEmail)
    {
        return Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);
    }
}
