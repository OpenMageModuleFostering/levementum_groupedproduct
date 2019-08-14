<?php
/**
 * User: ian.c
 * Date: 8/30/12 3:18 PM
 */
class Levementum_Groupedproduct_Block_Adminhtml_Sets_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'groupedproduct';
        $this->_controller = 'adminhtml_sets';
        $this->_mode       = 'edit';

        if ($this->_isAllowedAction('save')) {
            $this->_addButton('save_and_continue', array(
                                                        'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                                                        'onclick' => 'saveAndContinueEdit()',
                                                        'class'   => 'save',
                                                   ), -100);
            $this->_updateButton('save', 'label', Mage::helper('groupedproduct')->__('Save Set'));
            $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        } else {
            $this->_removeButton('save');
        }

        $this->_removeButton('delete');
    }

    public function getHeaderText()
    {
        return Mage::helper('groupedproduct')->__('Edit Set');
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     *
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('levementum/levementum_grouped_sets/'.$action);
    }
}