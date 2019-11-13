<?php

namespace Tegme\Factories;

use Tegme\Types\Dom\Attribute;
use Tegme\Types\Dom\DomPage;
use Tegme\Types\Dom\Nodes\NodeElement;
use Tegme\Types\Dom\Nodes\NodeInterface;
use Tegme\Types\Dom\Nodes\NodeText;
use Tegme\Types\Dom\Tags\TagInterface;
use Tegme\Types\Responses\Account;
use Tegme\Types\Responses\Page;
use Tegme\Types\Responses\PageList;
use Tegme\Types\Responses\PageViews;
use Tegme\Utils\ArrayUtil;

class TelegraphResponseFactory extends AbstractTelegraphResponseFactory
{
    /** @var NodeInterface[] */
    private $childrenNodes;

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
        // Null for /revokeAccessTokenMethod:
        $shortName = isset($apiResponse['short_name']) ? $apiResponse['short_name'] : null;
        $authorName = isset($apiResponse['author_name']) ? $apiResponse['author_name'] : null;
        $authorUrl = isset($apiResponse['author_url']) ? $apiResponse['author_url'] : null;

        // Optional by default:
        $accessToken = isset($apiResponse['access_token']) ? $apiResponse['access_token'] : null;
        $authUrl = isset($apiResponse['auth_url']) ? $apiResponse['auth_url'] : null;
        $pageCount = isset($apiResponse['page_count']) ? $apiResponse['page_count'] : null;

        return new Account(
            $shortName,
            $authorName,
            $authorUrl,
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
        if (isset($apiResponse['content'])) {
            $content = $apiResponse['content'];
            $content = $this->buildNodeElements($content);
            $content = new DomPage($content);
        } else {
            $content = null;
        }
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

    /**
     * @param array $nodes array representation of nodes.
     * @return NodeInterface[]
     */
    private function buildNodeElements(array $nodes)
    {
        $nodesObjects = [];
        foreach ($nodes as $node) {
            if (isset($node['tag'])) {
                if (isset($node['children'])) {
                    $this->buildChildrenNode($node['children']);
                }

                $nodesObjects[] = new NodeElement(
                    $this->createTag($node),
                    $this->childrenNodes
                );

                $this->childrenNodes = null;
            } else {
                $nodesObjects = new NodeText($node);
            }
        }

        return $nodesObjects;
    }

    /**
     * @param array $children
     * @return array
     */
    private function buildChildrenNode(array $children)
    {
        if (isset($children['children'])) {
            $this->childrenNodes[] = new NodeElement(
                $this->createTag($children),
                $this->buildChildrenNode($children['children'])
            );
        } elseif (isset($children[0]) > 0 && isset($children[0]['tag'])) {
            foreach ($children as $child) {
                $this->childrenNodes[] = new NodeElement(
                    $this->createTag($child),
                    isset($child['children']) ? $child['children'] : null
                );
            }
        } elseif (!isset($children['tag'])) {
            $this->childrenNodes[] = new NodeText(array_pop($children));
        } else {
            $this->childrenNodes[] = new NodeElement(
                $this->createTag($children),
                isset($children['children']) ? $children['children'] : null
            );
        }

        return $children;
    }

    /**
     * @param array $node
     * @return TagInterface
     */
    private function createTag(array $node)
    {
        $tagName = isset($node['tag']) ? $node['tag'] : null;

        if ($tagName === null) {
            return null;
        }

        $tagName = '\Tegme\Types\Dom\Tags\\' . ucfirst($tagName);

        if (!class_exists($tagName)) {
            return null;
        }

        $attributes = isset($node['attrs']) ? $node['attrs'] : null;
        $attributesObjArr = [];
        if ($attributes !== null) {
            if (ArrayUtil::isAssoc($attributes)) {
                $attributesObjArr[] = new Attribute(key($attributes), current($attributes));
            } else {
                foreach ($attributes as $attribute) {
                    $attributesObjArr[] = new Attribute(key($attribute), current($attribute));
                }
            }
        }

        return new $tagName($attributesObjArr);
    }
}
