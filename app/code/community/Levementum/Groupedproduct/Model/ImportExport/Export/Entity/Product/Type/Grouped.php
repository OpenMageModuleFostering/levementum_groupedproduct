<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Export entity product type grouped model
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
if (file_exists('Mage/ImportExport/Model/Export/Entity/Product/Type/Grouped')) {
    include_once('Mage/ImportExport/Model/Export/Entity/Product/Type/Grouped');
}
class Levementum_Groupedproduct_Model_ImportExport_Export_Entity_Product_Type_Grouped
    extends Mage_ImportExport_Model_Export_Entity_Product_Type_Grouped
{
    public function __construct()
    {
        //incase they implement in the future.
        if (method_exists('Mage_ImportExport_Model_Export_Entity_Product_Type_Grouped', '__construct')
            || method_exists('Mage_ImportExport_Model_Export_Entity_Product_Type_Abstract', '__construct')) {
            parent::__construct();
        }

        $this->mergeDisabledAttributes();
    }

    protected function mergeDisabledAttributes() {
        $this->_disabledAttrs[] = 'lev_displayed_attributes';
    }
}
