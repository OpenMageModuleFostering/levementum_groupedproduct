<?php
/**
 * Used in creating options for All|Specified config value selection
 *
 */
class Levementum_Groupedproduct_Model_System_Config_Source_AllNumber
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'all', 'label'=>Mage::helper('adminhtml')->__('All')),
            array('value' => 'other', 'label'=>Mage::helper('adminhtml')->__('Specified'))
        );
    }

}
