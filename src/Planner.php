<?php

namespace KevinRuscoe;

use DateTime;
use DatePeriod;
use DateInterval;
use KevinRuscoe\DateBounds;

class Planner
{
    /**
     * The bounds of the planner.
     *
     * @var DateBounds
     */
    private $bounds;


    /**
     * An array of DateBounds day event.
     *
     * @var array
     */
    private $events = [];

    /**
     * Creates a new CarbonPlanner
     *
     * @param DayPlanner $bounds The planner bounds.
     */
    public function __construct(DateBounds $bounds)
    {
        $this->setBounds($bounds);

        return $this;
    }

    /**
     * Sets the bounds of the planner.
     *
     * @param DateBounds $bounds The planner bounds.
     *
     * @return DayPlanner $this
     */
    public function setBounds(DateBounds $bounds)
    {
        $this->bounds = $bounds;

        return $this;
    }

    /**
     * Gets the bounds of the planner.
     *
     * @return DateBounds
     */
    public function getBounds()
    {
        return $this->bounds;
    }

    public function addEvent(DateBounds $event)
    {
        if (! $this->getBounds()->overlaps($event)) {
            throw new \Exception("The given bounds is not without this bounds.");
        }

        if ($this->canFulfillEvent($event)) {
            throw new \Exception("An event already exists during the even bounds.");
        }

        $this->events[] = $event;

        return $this;
    }

    public function addEvents(array $events)
    {
        foreach ($events as $event) {
            $this->addEvent($event);
        }

        return $this;
    }

    public function getEvents()
    {
        return $this->events;
    }

    private function canFulfillEvent($event)
    {
        foreach ($this->getEvents() as $currentEvent) {
            if ($currentEvent->overlaps($event)) {
                return true;
            }
        }

        return false;
    }
}
