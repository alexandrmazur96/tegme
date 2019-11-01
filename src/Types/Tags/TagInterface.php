<?php

namespace Tegme\Types\Tags;

use Tegme\Types\Attribute;

/**
 * Base class for all page elements.<br>
 * Available elements for now:<br>
 * <i>
 * a, aside, b, blockquote, br, code, em, figcaption, figure,
 * h3, h4, hr, i, iframe, img, li, ol, p, pre, s, strong, u, ul, video.
 * </i>
 * @package Tegme\Types\PageElements
 */
interface TagInterface
{
    /**
     * Page element tag name.
     * <br><br>
     * Available tags:<br>
     * <code>
     * [a, aside, b, blockquote, br, code, em, figcaption, figure,
     * h3, h4, hr, i, iframe, img, li, ol, p, pre, s, strong, u, ul, video]
     * </code>
     * @return string
     */
    public function getTag();

    /**
     * Element attributes. Telegraph provide for now only two attributes,
     * which can be used: <b>href</b> and <b>src</b>
     *
     * @return Attribute|null
     */
    public function getAttribute();
}
