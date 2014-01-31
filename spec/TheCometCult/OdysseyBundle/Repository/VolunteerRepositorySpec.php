<?php

namespace spec\TheCometCult\OdysseyBundle\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Doctrine\Common\Collections\ArrayCollection;

class VolunteerRepositorySpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param Doctrine\ODM\MongoDB\UnitOfWork $uow
     * @param Doctrine\ODM\MongoDB\Mapping\ClassMetadata $classMetadata
     */
    function let($dm, $uow, $classMetadata)
    {
        $this->beConstructedWith($dm, $uow, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Repository\VolunteerRepository');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param Doctrine\ODM\MongoDB\Query\Builder $qb
     * @param Doctrine\MongoDB\Query\Query $query
     * @param Doctrine\MongoDB\EagerCursor $cursor
     */
    function it_should_count_admitted_volunteers($dm, $qb, $query, $cursor)
    {
        $dm->createQueryBuilder(Argument::any())->willReturn($qb);
        $qb->field('status')->shouldBeCalled()->willReturn($qb);
        $qb->equals('status_admitted')->shouldBeCalled()->willReturn($qb);
        $qb->getQuery()->shouldBeCalled()->willReturn($query);
        $query->count()->willReturn(5);

        $this->countAdmittedVolunteers()->shouldReturn(5);
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param Doctrine\ODM\MongoDB\Query\Builder $qb
     * @param Doctrine\MongoDB\Query\Query $query
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer1
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer2
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer3
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer4
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer5
     */
    function it_should_return_admitted_volunteers(
        $dm,
        $qb,
        $query,
        $volunteer1,
        $volunteer2,
        $volunteer3,
        $volunteer4,
        $volunteer5
    )
    {
        $dm->createQueryBuilder(Argument::any())->willReturn($qb);
        $qb->field('status')->shouldBeCalled()->willReturn($qb);
        $qb->equals('status_admitted')->shouldBeCalled()->willReturn($qb);
        $qb->getQuery()->shouldBeCalled()->willReturn($query);
        $volunteers = new ArrayCollection(array($volunteer1, $volunteer2, $volunteer3, $volunteer4, $volunteer5));
        $query->execute()->shouldBeCalled()->willReturn($volunteers);

        $this->getAdmittedVolunteers()->shouldReturn($volunteers);
    }
}
