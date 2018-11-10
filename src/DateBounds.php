<?php

namespace KevinRuscoe;

use DateTime;
use DatePeriod;
use DateInterval;

class DateBounds
{
    /**
     * The start of the bounds.
     *
     * @var DateTime;
     */
    private $start;

    /**
     * The end of the bounds.
     *
     * @var DateTime;
     */
    private $end;

    /**
     * Creates a DateBounds.
     *
     * @param DateTime      $start The start of the bounds.
     * @param null|DateTime $end   The end of the bounds.
     *
     * @return DateBounds
     */
    public function __construct(DateTime $start, DateTime $end = null)
    {
        $this->setStart($start);

        if (is_null($end)) {
            $end = clone $this->getStart();
            $end->setTime(23, 59, 59);
        }

        $this->setEnd($end);

        return $this;
    }

    /**
     * Sets the start of the bounds.
     *
     * @param DateTime $start The start of the bounds.
     *
     * @return DateBounds
     */
    public function setStart(DateTime $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Gets the start of the bounds.
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets the end of the bounds.
     *
     * @param DateTime $end The end of the bounds.
     *
     * @return DateBounds
     */
    public function setEnd(DateTime $end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Gets the end of the bounds.
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns whether of not the given bounds is within this bounds.
     *
     * @param DateBounds $otherBounds The bounds to check.
     *
     * @return bool
     */
    public function overlaps(DateBounds $otherBounds)
    {
        return (
            (
                $otherBounds->getStart() < $this->getEnd()
            ) &&
            (
                $otherBounds->getEnd() > $this->getStart()
            )
        );
    }

    /**
     * Converts the DateBounds to a DatePeriod.
     *
     * @param DateInterval $interval The interval.
     *
     * @return DatePeriod
     */
    public function toDatePeriod(DateInterval $interval)
    {
        return new DatePeriod(
            $this->getStart(),
            $interval,
            $this->getEnd()
        );
    }
}
