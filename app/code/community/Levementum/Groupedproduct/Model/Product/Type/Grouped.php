<?php

/**
 * Grouped product type implementation
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */

if (is_file('Mage/Catalog/Model/Product/Type/Grouped.php')) {
    include_once 'Mage/Catalog/Model/Product/Type/Grouped.php';
}

class Levementum_Groupedproduct_Model_Product_Type_Grouped extends Mage_Catalog_Model_Product_Type_Grouped
{
    /**
     * Retrieve array of associated products
     *
     * @param Mage_Catalog_Model_Product                                $product
     * @param Levementum_Groupedproduct_Block_Product_View_Type_Grouped $block
     *
     * @return array
     */
    public function getAssociatedProducts($product = null, Levementum_Groupedproduct_Block_Product_View_Type_Grouped $block = null)
    {
        if (!$this->getProduct($product)->hasData($this->_keyAssociatedProducts)) {
            $associatedProducts = array();

            if (!Mage::app()->getStore()->isAdmin()) {
                $this->setSaleableStatus($product);
            }

            $collection = $this->getAssociatedProductCollection($product)
                ->addAttributeToSelect('*')
                ->addFilterByRequiredOptions()
                ->setPositionOrder()
                ->addStoreFilter($this->getStoreFilter($product))
                ->addAttributeToFilter('status', array('in' => $this->getStatusFilters($product)));

            if (!is_null($block)) {
                /* Change ian.c on 5/9/12 at 12:05 PM
                 * Description: Add custom pager, we need to get the collection.
                 */
                $block->getToolbar()->setCollection($collection);
            }

            foreach ($collection as $item) {
                $associatedProducts[] = $item;
            }

            $this->getProduct($product)->setData($this->_keyAssociatedProducts, $associatedProducts);
        }

        return $this->getProduct($product)->getData($this->_keyAssociatedProducts);
    }
}
