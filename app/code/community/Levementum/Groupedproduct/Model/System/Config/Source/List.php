<?php

class Levementum_Groupedproduct_Model_System_Config_Source_List
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'grid', 'label'=>Mage::helper('adminhtml')->__('Grid')),
            array('value'=>'list', 'label'=>Mage::helper('adminhtml')->__('List')),
            array('value'=>'detail', 'label'=>Mage::helper('adminhtml')->__('Detail')),
        );
    }
}
