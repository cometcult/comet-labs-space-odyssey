<?php

namespace spec\TheCometCult\OdysseyBundle\Mailer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Mailer\MessageFactory');
    }

    function it_should_create_message()
    {
        $this
            ->create('test', 'test', 'test@test.com', 'test2@test.com')
            ->shouldHaveType('Swift_Message');
    }
}
