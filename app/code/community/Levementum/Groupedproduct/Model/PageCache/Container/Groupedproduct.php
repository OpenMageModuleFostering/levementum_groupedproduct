<?php

class Levementum_Groupedproduct_Model_PageCache_Container_Groupedproduct extends Enterprise_PageCache_Model_Container_Abstract
{
    const CACHE_TAG_PREFIX = 'LEVEMENTUM_GROUPED_TABLE_';

    protected function _getIdentifier()
    {
        return $this->_getProductId().'_'.$this->_getMode();
    }

    protected function _getMode() {
        $mode = Mage::app()->getRequest()->getParam('mode','list');
        return $mode;
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        $id = self::CACHE_TAG_PREFIX . md5($this->_placeholder->getAttribute('cache_id') . $this->_getIdentifier());

        return $id;
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

        $productId = $this->_getProductId();
        if ($productId && !Mage::registry('product')) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product) {
                Mage::register('product', $product);
            }
        }

        $block = new $blockClass;
        $block->setTemplate($template);
        return $block->toHtml();
    }
}