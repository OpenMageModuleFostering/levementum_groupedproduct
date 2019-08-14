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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


class Levementum_LevCore_Model_System_Config_Source_Attributes
{
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $sortedArray = array();

            /** @var $_attributes Mage_Eav_Model_Resource_Entity_Attribute_Collection */
            $_attributes = Mage::getSingleton('eav/config')
                ->getEntityType(Mage_Catalog_Model_Product::ENTITY)
                ->getAttributeCollection();

            /** @var $attribute Mage_Eav_Model_Entity_Attribute */
            $this->_options = array();
            foreach ($_attributes as $attribute) {
                $tmpArray = array(
                    'value' => $attribute->getAttributeCode(),
                    'label' => $attribute->getFrontend()->getLabel(),
                );

                $this->_options[] = $tmpArray;
            }

            ksort($sortedArray);

            foreach ($sortedArray as $tmpArray) {
                $this->_options[] = $tmpArray;
            }
        }

        return $this->_options;
    }
}
