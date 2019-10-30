<?php

namespace Tegme\Types\Response;

/**
 * This object represents a Telegraph account.
 * @package Tegme\Types
 */
final class Account
{
    /** @var string|null <b>OPTIONAL</b> */
    private $shortName;

    /** @var string|null <b>OPTIONAL</b> */
    private $authorName;

    /** @var string|null <b>OPTIONAL</b> */
    private $authorUrl;

    /** @var string|null <b>OPTIONAL</b> */
    private $accessToken;

    /** @var string|null <b>OPTIONAL</b> */
    private $authUrl;

    /** @var int|null <b>OPTIONAL</b> */
    private $pageCount;

    /**
     * Optional for revokeAccessToken action:
     * @param string|null $shortName
     * @param string|null $authorName
     * @param string|null $authorUrl
     *
     * Optional by default:
     * @param string|null $accessToken
     * @param string|null $authUrl
     * @param int|null $pageCount
     */
    public function __construct(
        $shortName = null,
        $authorName = null,
        $authorUrl = null,
        $accessToken = null,
        $authUrl = null,
        $pageCount = null
    ) {
        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->accessToken = $accessToken;
        $this->authUrl = $authUrl;
        $this->pageCount = $pageCount;
    }

    /**
     * Account name, helps users with several accounts remember
     * which they are currently using.
     * Displayed to the user above the "Edit/Publish" button on Telegra.ph, other users don't see this name.
     * @return string|null
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Default author name used when creating new articles.
     * @return string|null
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Profile link, opened when users click on the author's name below the title.
     * Can be any link, not necessarily to a Telegram profile or channel.
     * @return string|null
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * Only returned by the createAccount and revokeAccessToken method.
     * Access token of the Telegraph account.
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * URL to authorize a browser on telegra.ph and connect it to a Telegraph account.
     * This URL is valid for only one use and for 5 minutes only.
     * @return string|null
     */
    public function getAuthUrl()
    {
        return $this->authUrl;
    }

    /**
     * Number of pages belonging to the Telegraph account.
     * @return int|null
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }
}
