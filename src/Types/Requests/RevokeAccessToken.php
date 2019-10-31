<?php

namespace Tegme\Types\Requests;

use Tegme\Types\Responses\Account;

/**
 * Use this method to revoke access_token and generate a new one, for example,
 * if the user would like to reset all connected sessions, or you have reasons to
 * believe the token was compromised.
 * @package Tegme\Types\Requests
 * @see Account on success, returns an Account object with new access_token and auth_url fields.
 */
final class RevokeAccessToken extends BaseRequest
{
    /** @var string */
    private $accessToken;

    /**
     * @param string $accessToken Access token of the Telegraph account.
     *
     * @see Account on success, returns an Account object with new access_token and auth_url fields.
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
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
        return [
            'access_token' => $this->accessToken,
        ];
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
        return false;
    }

    /**
     * Return method name, which would be queried by this request.
     *
     * @return string
     * @link https://telegra.ph/api list of available methods you can find here.
     */
    public function getMethod()
    {
        return 'revokeAccessToken';
    }

    /**
     * Return path if exists.
     * @return string
     */
    public function getPath()
    {
        return '';
    }

    /**
     * Nothing to validate in this request.
     * @return void
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    protected function validate()
    {
    }
}
