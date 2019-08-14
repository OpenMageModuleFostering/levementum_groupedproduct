<?php
/**
 * User: icoast@levementum.com
 * Date: 11/30/12 4:41 PM
 */

class Levementum_Groupedproduct_Block_Adminhtml_System_Config_Form_Field_Primary extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Enter description here...
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $displayedAttributesId = Levementum_Groupedproduct_Helper_Config::MODULE_XPATH_PREFIX.'_groupedproduct_displayed_attributes';
        $primaryAttributesId = Levementum_Groupedproduct_Helper_Config::MODULE_XPATH_PREFIX.'_groupedproduct_primary_attribute';

        $afterHtml = Mage::helper('groupedproduct/admin')
            ->getPrimaryAttributeAfterHtml($displayedAttributesId,$primaryAttributesId,$element->getEscapedValue());
        $element->setAfterElementHtml($afterHtml);

        return $element->getElementHtml();
    }
}