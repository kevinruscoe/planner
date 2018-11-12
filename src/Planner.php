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
     * An array of DateBounds events.
     *
     * @var array
     */
    private $events = [];

    /**
     * Creates a new Planner
     *
     * @param DateBounds $bounds The planner bounds.
     *
     * @return Planner $this
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
     * @return Planner $this
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

    /**
     * Adds an event to the planner.
     *
     * @param DateBounds $event
     *
     * @return Planner $this
     */
    public function addEvent(DateBounds $event)
    {
        if (! $this->getBounds()->overlaps($event)) {
            throw new \Exception("The given DateBounds is not within this DateBounds.");
        }

        if ($this->canFulfillEvent($event)) {
            throw new \Exception("A DateBounds already exists during the given DateBounds.");
        }

        $this->events[] = $event;

        return $this;
    }

    /**
     * Adds an array of events to the planner.
     *
     * @param array $events
     *
     * @return Planner $this
     */
    public function addEvents(array $events)
    {
        foreach ($events as $event) {
            $this->addEvent($event);
        }

        return $this;
    }

    /**
     * Gets the events of the planner.
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Checks if the event can be added.
     *
     * @param DateBounds $event
     *
     * @return bool
     */
    public function canFulfillEvent($event)
    {
        foreach ($this->getEvents() as $currentEvent) {
            if ($currentEvent->overlaps($event)) {
                return true;
            }
        }

        return false;
    }
}
