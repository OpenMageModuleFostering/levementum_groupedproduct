<?php
/**
 * User: ian.c
 * Date: 8/30/12 3:16 PM
 */


class Levementum_Groupedproduct_Block_Adminhtml_Sets extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_sets';
        $this->_blockGroup = 'groupedproduct';
        $this->_headerText = Mage::helper('groupedproduct')->__('Default Columns by Set');
        $this->removeButton('add');
    }
}