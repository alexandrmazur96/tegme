<?php

namespace Tegme\Types\Requests;

use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Types\Response\PageViews;

/**
 * Use this method to get the number of views for a Telegraph article.
 * @package Tegme\Types\Requests
 * @see PageViews returns a PageViews object on success. By default, the total number of page views will be returned.
 */
final class GetViews extends BaseRequest
{
    /** @var string */
    private $path;

    /** @var int|null */
    private $year;

    /** @var int|null */
    private $month;

    /** @var int|null */
    private $day;

    /** @var int|null */
    private $hour;

    /**
     * @param string $path      Path to the Telegraph page (in the format
     *                          Title-12-31, where 12 is the month and 31 the day the article was first published).
     *
     * @param int|null $year    <i>Required if month is passed</i>. If passed, the number
     *                          of page views for the requested year will be returned.
     *
     * @param int|null $month   <i>Required if day is passed</i>. If passed, the number
     *                          of page views for the requested month will be returned.
     *
     * @param int|null $day     <i>Required if hour is passed</i>. If passed, the number of
     *                          page views for the requested day will be returned.
     *
     * @param int|null $hour    If passed, the number of page views for the requested hour will be returned.
     *
     * @throws InvalidRequestInfoException look at exception to see what exactly wrong.
     */
    public function __construct(
        $path,
        $year = null,
        $month = null,
        $day = null,
        $hour = null
    ) {
        $this->path = $path;
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->validate();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $requestPrototype = [];

        if ($this->year !== null) {
            $requestPrototype['year'] = $this->year;
        }

        if ($this->month !== null) {
            $requestPrototype['month'] = $this->year;
        }

        if ($this->day !== null) {
            $requestPrototype['day'] = $this->day;
        }

        if ($this->hour !== null) {
            $requestPrototype['hour'] = $this->hour;
        }

        return $requestPrototype;
    }

    /**
     * Indicate that request should be compatible with method/path form.
     *
     * telegra.ph have two syntax for querying API:
     * https://api.telegra.ph/%method% and https://api.telegra.ph/%method%/%path%
     *
     * So depends on this flag we know to which one form we should request.
     *
     * @return bool
     */
    public function hasPath()
    {
        return true;
    }

    /**
     * Return method name, which would be queried by this request.
     *
     * @return string
     * @link https://telegra.ph/api list of available methods you can find here.
     */
    public function getMethod()
    {
        return 'getViews';
    }

    /**
     * Return path if exists.
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Validate request information before making request.
     * @return void
     * @throws InvalidRequestInfoException
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    protected function validate()
    {
        if ($this->year !== null && ($this->year < 2000 || $this->year > 2100)) {
            throw new InvalidRequestInfoException('year parameter should be between 2000 and 2100.');
        }

        if ($this->month !== null && ($this->month < 1 || $this->month > 12)) {
            throw new InvalidRequestInfoException('month parameter should be between 1 and 12.');
        }

        if ($this->day !== null && ($this->day < 1 || $this->day > 31)) {
            throw new InvalidRequestInfoException('day parameter should be between 1 and 31.');
        }

        if ($this->hour !== null && ($this->hour < 0 || $this->hour > 24)) {
            throw new InvalidRequestInfoException('hour parameter should be between 0 and 24.');
        }

        if ($this->hour !== null && $this->day === null) {
            throw new InvalidRequestInfoException('day parameter required.');
        }

        if ($this->day !== null && $this->month === null) {
            throw new InvalidRequestInfoException('month parameter required.');
        }

        if ($this->month !== null && $this->year === null) {
            throw new InvalidRequestInfoException('year parameter required.');
        }
    }
}
