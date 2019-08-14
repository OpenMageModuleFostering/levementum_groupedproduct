<?php
/**
 * User: ian.c
 * Date: 5/9/12 2:09 PM
 * File: Data.php
 * To change this template use File | Settings | File Templates.
 */

class Levementum_Groupedproduct_Helper_Config extends Mage_Core_Helper_Abstract
{
    const MODULE_XPATH_PREFIX = 'levementum_grouped';

    public function isThisModuleEnabled()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/enabled');
    }

    public function isGridViewEnabled()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/display/enabled_grid_view');
    }

    public function displayIndividualAddToCart()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/display/display_individual_add');
    }

    public function allowSortAllAttributes()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/allow_sort_all_attributes');
    }

    public function getDefaultPageLengthAll($_mode = 'list')
    {
        if ($this->getToolbarDisplayMode($_mode, 'limiter') == 'none') {
            return 'all';
        }
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/default_page_length_all');
    }

    /**
     * @return int
     */
    public function getDefaultPageLength()
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/default_page_length');
    }

    /**
     * @param $mode string
     *
     * @return bool
     */
    public function displayFirstLast($mode)
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/display_'.$mode.'/display_first_last');
    }

    /**
     * @return string
     */
    public function getPaginationPrepend($_mode = 'list')
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/display_'.$_mode.'/pagination_prepend');
    }

    public function getDefaultDisplayPage()
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/default_display_page');
    }

    public function allowAllAttributes()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/allow_all_attributes');
    }

    public function getToolbarDisplayMode($mode, $type)
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/display_'.$mode.'/'.$type);
    }

    public function getDefaultDisplayedAttributes()
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/displayed_attributes');
    }

    public function getDefaultPrimaryAttribute()
    {
        return Mage::getStoreConfig(self::MODULE_XPATH_PREFIX.'/groupedproduct/primary_attribute');
    }
}