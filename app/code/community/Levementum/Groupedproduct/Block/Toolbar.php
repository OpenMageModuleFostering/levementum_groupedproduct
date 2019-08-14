<?php
/**
 * User: ian.c
 * Date: 5/9/12 2:10 PM
 * File: Toolbar.php
 */

class Levementum_Groupedproduct_Block_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar {

    /**
     * Init Toolbar
     * Overwrite parent
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_availableMode = array(
            'grid' => $this->__('Grid'),
            'detail' => $this->__('Detail'),
            'list' => $this->__('List')
        );
        $this->setTemplate('levementum/groupedproduct/product/list/toolbar.phtml');
    }

    public function getPagerHtml()
    {
        /* @var $pagerBlock Mage_Page_Block_Html_Pager */
        $pagerBlock = $this->getLayout()->createBlock('page/html_pager');

        if ($pagerBlock instanceof Varien_Object) {
            $pagerBlock->setAvailableLimit($this->getAvailableLimit());

            $pagerBlock->setUseContainer(false)
                ->setShowPerPage(false)
                ->setShowAmounts(false)
                ->setLimitVarName($this->getLimitVarName())
                ->setPageVarName($this->getPageVarName())
                ->setLimit($this->getLimit())
                ->setCollection($this->getCollection());
            return $pagerBlock->toHtml();
        }
        return '';
    }

    /**
     * Get specified products limit display per page
     *
     * @return string
     */
    public function getLimit()
    {
        /* Change ian.c on 6/29/12 at 10:06 AM
         * Description: If the current mode is list, paging will be done on client side, force to all.
         */
        if ($this->getCurrentMode() == 'list' || $this->getCurrentMode() == 'detail') {
            $this->setData('_current_limit','all');
            $this->setLimit('all');
        }

        $limit = $this->_getData('_current_limit');
        if ($limit) {
            return $limit;
        }

        $limits = $this->getAvailableLimit();
        $defaultLimit = $this->getDefaultPerPageValue();
        if (!$defaultLimit || !isset($limits[$defaultLimit])) {
            $keys = array_keys($limits);
            $defaultLimit = $keys[0];
        }

        $limit = $this->getRequest()->getParam($this->getLimitVarName());
        if ($limit && isset($limits[$limit])) {
            if ($limit == $defaultLimit) {
                Mage::getSingleton('catalog/session')->unsLimitPage();
            } else {
                $this->_memorizeParam('limit_page', $limit);
            }
        } else {
            $limit = Mage::getSingleton('catalog/session')->getLimitPage();
        }
        if (!$limit || !isset($limits[$limit])) {
            /* Change ian.c on 5/15/12 at 4:51 PM
             * Description: default limit set to all for grouped product
             */
            $limit = 'all';
        }

        $this->setData('_current_limit', $limit);
        return $limit;
    }

    /**
     * Retrieve current View mode
     *
     * @return string
     */
    public function getCurrentMode()
    {
        $mode = $this->_getData('_current_grid_mode');
        if ($mode) {
            return $mode;
        }

        $defaultMode = Mage::helper('groupedproduct/config')->getDefaultDisplayPage();
        $mode = $this->getRequest()->getParam($this->getModeVarName());
        if ($mode) {
            if ($mode == $defaultMode) {
                Mage::getSingleton('catalog/session')->unsDisplayMode();
            } else {
                $this->_memorizeParam('display_mode', $mode);
            }
        } else {
            $mode = Mage::getSingleton('catalog/session')->getDisplayMode();
        }

        if (!$mode || !isset($this->_availableMode[$mode])) {
            $mode = $defaultMode;
        }

        //If grid mode is disabled and the selected mode is grid, override it.
        if ($mode == 'grid' && !Mage::helper('groupedproduct/config')->isGridViewEnabled()) {
            //if the default grid mode in config is 'grid' and grid mode is disabled, default to list.
            if ($defaultMode == 'grid') {
                $mode = 'list';
            } else {
                $mode = $defaultMode;
            }
        }

        $this->setData('_current_grid_mode', $mode);

        return $mode;
    }
}