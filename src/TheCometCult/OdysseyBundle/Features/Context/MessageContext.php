<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\Gherkin\Node\PyStringNode;

use Symfony\Component\HttpKernel\KernelInterface;

use DateTime;

use Swift_Message;

use Mockery;

class MessageContext extends BehatContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface $kernel
     */
    private $kernel = null;

    /**
     * @param KernelInterface $kernel
     *
     * @return null
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @AfterScenario
     *
     * @return null
     */
    public function verifyPendingExpectations()
    {
        foreach ($this->kernel->getContainer()->getMockedServices() as $id => $service) {
            $this->kernel->getContainer()->unmock($id);
        }
        Mockery::close();
    }

    /**
     * @Given /^EMAIL SENDER expects to send mail to "([^"]*)" with:$/
     */
    public function emailSenderExpectsToSendMailToWith($toEmail, PyStringNode $content)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('subject')
            ->setFrom('no-reply@test.com')
            ->setTo('no-reply@test.com')
            ->setBody('body');
        $renderedLines = explode("\n", trim($content));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));
        $fromEmail = 'no-reply@test.com';
        $this->kernel->getContainer()
            ->mock('the_comet_cult_odyssey.mailer.message_factory', 'TheCometCult\OdysseyBundle\Mailer\MessageFactory')
            ->shouldReceive('create')
            ->with($subject, $body, $toEmail, $fromEmail)
            ->once()
            ->andReturn($message);

        $this->kernel->getContainer()
            ->mock('swiftmailer.mailer.default', 'Swift_Mailer')
            ->shouldReceive('send')
            ->with($message)
            ->once()
            ->andReturn(true);
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}