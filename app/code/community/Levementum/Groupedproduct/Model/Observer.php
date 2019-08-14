<?php
/**
 * User: ian.c
 * Date: 7/18/12 12:41 PM
 *
 * The goal of this file is to keep the attribute list for "lev_displayed_attributes" in sync with current attribute list.
 * This allows importing/exporting using built-in Magento.
 */

class Levementum_Groupedproduct_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function addLevementumGroupedHandle(Varien_Event_Observer $observer)
    {
        $product = Mage::registry('current_product');

        /**
         * Return if it is not product page
         */
        if (!($product instanceof Mage_Catalog_Model_Product)) {
            return;
        }

        $update = $observer->getEvent()->getLayout()->getUpdate();

        $currentHandles = $update->getHandles();

        if (in_array('PRODUCT_TYPE_grouped', $currentHandles)) {
            if (Mage::helper('groupedproduct/config')->isThisModuleEnabled()) {
                $update->addHandle('LEVEMENTUM_PRODUCT_TYPE_grouped');
            }
        } elseif (in_array('PRODUCT_TYPE_simple', $currentHandles)) {
            if (Mage::helper('groupedproduct/config')->isThisModuleEnabled()) {
                $update->addHandle('LEVEMENTUM_PRODUCT_TYPE_simple');
            }
        }
    }
}