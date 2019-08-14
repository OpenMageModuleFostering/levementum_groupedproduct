<?php
/**
 * User: icoast@levementum.com
 * Date: 11/14/12 1:54 PM
 */

class Levementum_Levementum_Model_PageCache_Container_Tabs extends Enterprise_PageCache_Model_Container_Abstract
{
    /**
     * Get customer identifier from cookies
     *
     * @return string
     */
    protected function _getIdentifier()
    {
        return $this->_getCookieValue(Enterprise_PageCache_Model_Cookie::COOKIE_CART, '');
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        return 'LEVEMENTUM_TABS_' . md5($this->_placeholder->getAttribute('cache_id') . $this->_getIdentifier());
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $blockClass = $this->_placeholder->getAttribute('block');
        $template = $this->_placeholder->getAttribute('template');

        $block = new $blockClass;
        $block->setTemplate($template);
        return $block->toHtml();
    }
}