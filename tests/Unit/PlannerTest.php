<?php

namespace KevinRuscoe\Tests;

use DateTime;
use DatePeriod;
use DateInterval;

use KevinRuscoe\Planner;
use KevinRuscoe\DateBounds;

use PHPUnit\Framework\TestCase;

class PlannerTest extends TestCase
{
    public function test_can_instantiate()
    {
        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $planner = new Planner($bounds);

        $this->assertTrue($planner instanceOf Planner);
    }

    public function test_can_add_event()
    {
        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $lunch = new DateBounds(
            new DateTime('today 1pm'),
            new DateTime('today 2pm')
        );

        $planner = new Planner($bounds);

        $planner->addEvent($lunch);

        $this->assertCount(1, $planner->getEvents());

        $planner->addEvents([
            new DateBounds(
                new DateTime('today 2pm'),
                new DateTime('today 2:30pm')
            ),
            new DateBounds(
                new DateTime('today 2:30pm'),
                new DateTime('today 3pm')
            )
        ]);

        $this->assertCount(3, $planner->getEvents());
    }

    public function test_cant_add_event_outside_bound()
    {
        $this->expectException(\Exception::class);

        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $morningShower = new DateBounds(
            new DateTime('today 8am'),
            new DateTime('today 8:10am')
        );

        $planner = new Planner($bounds);

        $planner->addEvent($morningShower);
    }

    public function test_cant_add_event_that_already_exists()
    {
        $this->expectException(\Exception::class);

        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $lunch = new DateBounds(
            new DateTime('today 1pm'),
            new DateTime('today 2pm')
        );

        $planner = new Planner($bounds);

        $planner->addEvent($lunch);

        $lunchTimeInteruptionFromManagement = new DateBounds(
            new DateTime('today 1:05pm'),
            new DateTime('today 1:45pm')
        );

        $planner->addEvent($lunchTimeInteruptionFromManagement);
    }

    public function test_cant_add_event_over_two_events()
    {
        $this->expectException(\Exception::class);

        $planner = new Planner(
            new DateBounds(
                new DateTime('today 9am'),
                new DateTime('today 5pm')
            )
        );

        $planner->addEvents([
            new DateBounds(
                new DateTime('today 1pm'),
                new DateTime('today 2pm')
            ),
            new DateBounds(
                new DateTime('today 2pm'),
                new DateTime('today 3pm')
            )
        ]);

        $planner->addEvent(
            new DateBounds(
                new DateTime('today 1:30pm'),
                new DateTime('today 2:30pm')
            )
        );
    }
}
