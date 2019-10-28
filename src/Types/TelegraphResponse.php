<?php

namespace Tegme\Types;

/**
 * Represent request response from telegra.ph API.
 * @package Tegme\Types
 */
class TelegraphResponse
{
    /**
     * @var bool
     */
    private $ok;

    /**
     * @var mixed|null
     */
    private $result;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @param bool $ok
     * @param mixed|null $result
     * @param string|null $error
     */
    public function __construct($ok, $result = null, $error = null)
    {
        $this->ok = $ok;
        $this->result = $result;
        $this->error = $error;
    }

    /**
     * Indicate request result.
     * @return bool
     */
    public function isOk()
    {
        return $this->ok;
    }

    /**
     * Successful request result data.
     * Look at Tegme/Types package to found available types.
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Error information
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }
}
