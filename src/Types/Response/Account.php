<?php

namespace Tegme\Types\Response;

/**
 * This object represents a Telegraph account.
 * @package Tegme\Types
 */
final class Account
{
    /**
     * Account name, helps users with several accounts remember
     * which they are currently using.
     * Displayed to the user above the "Edit/Publish" button on Telegra.ph, other users don't see this name.
     * @var string
     */
    private $shortName;

    /**
     * Default author name used when creating new articles.
     * @var string
     */
    private $authorName;

    /**
     * Profile link, opened when users click on the author's name below the title.
     * Can be any link, not necessarily to a Telegram profile or channel.
     * @var string
     */
    private $authorUrl;

    /**
     * Optional. Only returned by the createAccount and revokeAccessToken method.
     * Access token of the Telegraph account.
     * @var string|null <b>OPTIONAL</b>
     */
    private $accessToken;

    /**
     * URL to authorize a browser on telegra.ph and connect it to a Telegraph account.
     * This URL is valid for only one use and for 5 minutes only.
     * @var string|null <b>OPTIONAL</b>
     */
    private $authUrl;

    /**
     * Number of pages belonging to the Telegraph account.
     * @var int|null <b>OPTIONAL</b>
     */
    private $pageCount;

    /**
     * @param string $shortName
     * @param string $authorName
     * @param string $authorUrl
     * @param string $accessToken
     * @param string $authUrl
     * @param int $pageCount
     */
    public function __construct(
        $shortName,
        $authorName,
        $authorUrl,
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
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string|null
     */
    public function getAuthUrl()
    {
        return $this->authUrl;
    }

    /**
     * @return int|null
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }
}
