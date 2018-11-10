<?php

namespace KevinRuscoe\Tests;

use DateTime;
use DatePeriod;
use DateInterval;

use KevinRuscoe\DateBounds;

use PHPUnit\Framework\TestCase;

class DateBoundsTest extends TestCase
{
    public function test_can_instantiate()
    {
        $bounds = new DateBounds(new DateTime('today 9am'));

        $this->assertTrue($bounds instanceOf DateBounds);

        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $this->assertTrue($bounds instanceOf DateBounds);
    }

    public function test_cant_instantiate_without_args()
    {
        $this->expectException(\ArgumentCountError::class);

        new DateBounds;
    }

    public function test_can_get_and_set_bounds()
    {
        $start = new DateTime('today 9am');
        $end = new DateTime('today 5pm');

        $bounds = new DateBounds(new DateTime('now'));

        $bounds->setStart($start);

        $this->assertEquals($bounds->getStart(), $start);

        $bounds->setEnd($end);

        $this->assertEquals($bounds->getEnd(), $end);
    }

    public function test_a_overlaps_b()
    {
        $a = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $b = new DateBounds(
            new DateTime('today 1pm'),
            new DateTime('today 2pm')
        );

        $this->assertTrue($a->overlaps($b));
    }

    public function test_b_overlaps_a()
    {
        $a = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $b = new DateBounds(
            new DateTime('today 1pm'),
            new DateTime('today 2pm')
        );

        $this->assertTrue($b->overlaps($b));
    }

    public function test_can_convert_bounds_to_a_date_period()
    {
        $bounds = new DateBounds(
            new DateTime('today 9am'),
            new DateTime('today 5pm')
        );

        $this->assertTrue(
            $bounds->toDatePeriod(new DateInterval('PT1H')) instanceOf DatePeriod
        );
    }
}
