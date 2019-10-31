<?php

namespace Tegme;

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Types\Requests\CreateAccount;
use Tegme\Types\Requests\CreatePage;
use Tegme\Types\Requests\EditAccountInfo;
use Tegme\Types\Requests\EditPage;
use Tegme\Types\Requests\GetAccountInfo;
use Tegme\Types\Requests\GetPage;
use Tegme\Types\Requests\GetPageList;
use Tegme\Types\Requests\GetViews;
use Tegme\Types\Requests\RevokeAccessToken;
use Tegme\Types\Responses\Account;
use Tegme\Types\Responses\Page;
use Tegme\Types\Responses\PageList;
use Tegme\Types\Responses\PageViews;

/**
 * Telegraph client.
 * @package Tegme
 */
class Telegraph extends BaseTelegraphClient
{
    /**
     * Use this method to create a new Telegraph account.
     * Most users only need one account, but this can be useful
     * for channel administrators who would like to keep
     * individual author names and profile links for each of their channels.
     *
     * @param CreateAccount $request
     * @return Account
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function createAccount(CreateAccount $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Account $accountObj */
        $accountObj = $telegraphResponse->getResult();

        return $accountObj;
    }

    /**
     * Use this method to update information about a Telegraph account.
     * Pass only the parameters that you want to edit.
     *
     * @param EditAccountInfo $request
     * @return Account
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function editAccountInfo(EditAccountInfo $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Account $accountObj */
        $accountObj = $telegraphResponse->getResult();

        return $accountObj;
    }

    /**
     * Use this method to get information about a Telegraph account.
     *
     * @param GetAccountInfo $request
     * @return Account
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function getAccountInfo(GetAccountInfo $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Account $accountObj */
        $accountObj = $telegraphResponse->getResult();

        return $accountObj;
    }

    /**
     * Use this method to revoke access_token and generate a new one,
     * for example, if the user would like to reset all connected sessions,
     * or you have reasons to believe the token was compromised.
     *
     * @param RevokeAccessToken $request
     * @return Account
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function revokeAccessToken(RevokeAccessToken $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Account $accountObj */
        $accountObj = $telegraphResponse->getResult();

        return $accountObj;
    }

    /**
     * Use this method to create a new Telegraph page.
     *
     * @param CreatePage $request
     * @return Page
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function createPage(CreatePage $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Page $pageObj */
        $pageObj = $telegraphResponse->getResult();

        return $pageObj;
    }

    /**
     * Use this method to edit an existing Telegraph page.
     *
     * @param EditPage $request
     * @return Page
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function editPage(EditPage $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Page $pageObj */
        $pageObj = $telegraphResponse->getResult();

        return $pageObj;
    }

    /**
     * Use this method to get a Telegraph page.
     *
     * @param GetPage $request
     * @return Page
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function getPage(GetPage $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var Page $pageObj */
        $pageObj = $telegraphResponse->getResult();

        return $pageObj;
    }

    /**
     * Use this method to get a list of pages belonging to a Telegraph account.
     *
     * @param GetPageList $request
     * @return PageList
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function getPageList(GetPageList $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var PageList $pageListObj */
        $pageListObj = $telegraphResponse->getResult();

        return $pageListObj;
    }

    /**
     * Use this method to get the number of views for a Telegraph article.
     * By default, the total number of page views will be returned.
     *
     * @param GetViews $request
     * @return PageViews
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function getViews(GetViews $request)
    {
        $telegraphResponse = $this->call($request);

        /** @var PageViews $pageViewsObj */
        $pageViewsObj = $telegraphResponse->getResult();

        return $pageViewsObj;
    }
}
