<?php

class Levementum_Groupedproduct_Block_Product_View_Type_Grouped extends Mage_Catalog_Block_Product_View_Type_Grouped
{
    /** @var $toolbar Levementum_Groupedproduct_Block_Toolbar */
    public $toolbar;
    public $toolbar_made = false;

    public function _construct()
    {
        parent::_construct();
        $this->toolbar = Mage::app()->getLayout()->createBlock('groupedproduct/toolbar', microtime());

        if (!Mage::registry('grouped-product-id')) {
            Mage::register('grouped-product-id', $this->getProduct()->getId());
        }

        if ($this->toolbar->getCurrentMode() == 'grid' || $this->toolbar->getCurrentMode() == 'list') {
            Mage::getSingleton('catalog/session')->unsDisplayMode();
        }

        $this->setChild('toolbar', $this->toolbar);
    }

    public function inCartConfigure() {
        return Mage::helper('levcore')->inCurrentHandles('checkout_cart_configure');
    }

    public function getAssociatedProducts()
    {
        return $this->getProduct()->getTypeInstance(true)->getAssociatedProducts($this->getProduct(), $this);
    }

    /**
     * Set preconfigured values to grouped associated products
     * @return Mage_Catalog_Block_Product_View_Type_Grouped
     */
    public function setPreconfiguredValue()
    {
        $configValues = $this->getProduct()->getPreconfiguredValues()->getSuperGroup();
        if (is_array($configValues)) {
            $associatedProducts = $this->getAssociatedProducts();
            foreach ($associatedProducts as $item) {
                if (isset($configValues[$item->getId()])) {
                    $item->setQty($configValues[$item->getId()]);
                }
            }
        }

        return $this;
    }

    public function getPagerHtml()
    {
        if (!$this->toolbar_made) {
            /* Change ian.c on 5/9/12 at 1:56 PM
            * Description: added for custom toolbar/pagination
            */
            // use sortable parameters
            if ($orders = $this->getAvailableOrders()) {
                $this->toolbar->setAvailableOrders($orders);
            }
            if ($sort = $this->getDefaultOrder()) {
                $this->toolbar->setDefaultOrder($sort);
            }
            if ($dir = $this->getDefaultDirection()) {
                $this->toolbar->setDefaultDirection($dir);
            }
            /*
             * end custom addition
             */
        }

        return $this->getChildHtml('toolbar');
    }

    public function getDefaultDirection()
    {
        return 'asc';
    }

    public function getDefaultOrder()
    {
        return 'sku';
    }

    public function getMode()
    {
        return $this->getChild('toolbar')->getCurrentMode();
    }

    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    /**
     * Return reference to toolbar class.
     * @return Levementum_Groupedproduct_Block_Toolbar
     */
    public function getToolbar()
    {
        return $this->toolbar;
    }

    protected function _getPriceBlock($productTypeId)
    {
        if (!isset($this->_priceBlock[$productTypeId])) {
            $block = $this->_block;
            if (isset($this->_priceBlockTypes[$productTypeId])) {
                if ($this->_priceBlockTypes[$productTypeId]['block'] != '') {
                    $block = $this->_priceBlockTypes[$productTypeId]['block'];
                }
            }
            $this->_priceBlock[$productTypeId] = Mage::app()->getLayout()->createBlock($block);
        }
        return $this->_priceBlock[$productTypeId];
    }
}
