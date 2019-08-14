<?php

class Levementum_Groupedproduct_Model_System_Config_Source_Datatables
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'both', 'label'=>Mage::helper('adminhtml')->__('Both')),
            array('value'=>'top', 'label'=>Mage::helper('adminhtml')->__('Top')),
            array('value'=>'bottom', 'label'=>Mage::helper('adminhtml')->__('Bottom')),
            array('value'=>'none', 'label'=>Mage::helper('adminhtml')->__('None')),
        );
    }
}
