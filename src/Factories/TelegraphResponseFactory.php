<?php

namespace Tegme\Factories;

use Tegme\Types\Response\Account;
use Tegme\Types\Response\Page;
use Tegme\Types\Response\PageList;
use Tegme\Types\Response\PageViews;

class TelegraphResponseFactory extends AbstractTelegraphResponseFactory
{
    /**
     * @param array $apiResponse
     * @param string $method
     * @return mixed
     */
    public function build(array $apiResponse, $method)
    {
        $method = 'build' . ucfirst($method) . 'Response';

        return $this->{$method}($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Account
     */
    protected function buildCreateAccountResponse(array $apiResponse)
    {
        return $this->buildAccountObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Page
     */
    protected function buildCreatePageResponse(array $apiResponse)
    {
        return $this->buildPageObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Account
     */
    protected function buildEditAccountInfoResponse(array $apiResponse)
    {
        return $this->buildAccountObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Page
     */
    protected function buildEditPageResponse(array $apiResponse)
    {
        return $this->buildPageObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Account
     */
    protected function buildGetAccountInfoResponse(array $apiResponse)
    {
        return $this->buildAccountObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Page
     */
    protected function buildGetPageResponse(array $apiResponse)
    {
        return $this->buildPageObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return PageList
     */
    protected function buildGetPageListResponse(array $apiResponse)
    {
        $rawPages = $apiResponse['pages'];
        $pagesList = [];
        foreach ($rawPages as $rawPage) {
            $pagesList[] = $this->buildPageObject($rawPage);
        }

        return new PageList($apiResponse['total_count'], $pagesList);
    }

    /**
     * @param array $apiResponse
     * @return PageViews
     */
    protected function buildGetViewsResponse(array $apiResponse)
    {
        return new PageViews($apiResponse['views']);
    }

    /**
     * @param array $apiResponse
     * @return Account
     */
    protected function buildRevokeAccessTokenResponse(array $apiResponse)
    {
        return $this->buildAccountObject($apiResponse);
    }

    /**
     * @param array $apiResponse
     * @return Account
     */
    private function buildAccountObject(array $apiResponse)
    {
        $accessToken = isset($apiResponse['access_token']) ? $apiResponse['access_token'] : null;
        $authUrl = isset($apiResponse['auth_url']) ? $apiResponse['auth_url'] : null;
        $pageCount = isset($apiResponse['page_count']) ? $apiResponse['page_count'] : null;

        return new Account(
            $apiResponse['short_name'],
            $apiResponse['author_name'],
            $apiResponse['author_url'],
            $accessToken,
            $authUrl,
            $pageCount
        );
    }

    /**
     * @param array $apiResponse
     * @return Page
     */
    private function buildPageObject(array $apiResponse)
    {
        $authorName = isset($apiResponse['author_name']) ? $apiResponse['author_name'] : null;
        $authorUrl = isset($apiResponse['author_url']) ? $apiResponse['author_url'] : null;
        $imageUrl = isset($apiResponse['image_url']) ? $apiResponse['image_url'] : null;
        //todo:: replace content with proper Node object
        $content = isset($apiResponse['content']) ? $apiResponse['content'] : null;
        $canEdit = isset($apiResponse['can_edit']) ? $apiResponse['can_edit'] : null;

        return new Page(
            $apiResponse['path'],
            $apiResponse['url'],
            $apiResponse['title'],
            $apiResponse['description'],
            $apiResponse['views'],
            $authorName,
            $authorUrl,
            $imageUrl,
            $content,
            $canEdit
        );
    }
}
