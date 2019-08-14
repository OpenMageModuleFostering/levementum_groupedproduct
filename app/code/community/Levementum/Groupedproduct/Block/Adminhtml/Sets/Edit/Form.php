<?php
/**
 * User: ian.c
 * Date: 8/30/12 3:19 PM
 */

class Levementum_Groupedproduct_Block_Adminhtml_Sets_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::registry('sets_data')) {
            $data = Mage::registry('sets_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form(array(
                                          'id'      => 'edit_form',
                                          'action'  => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                          'method'  => 'post',
                                          'enctype' => 'multipart/form-data',
                                     ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $setsSource = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();

        $fieldset = $form->addFieldset('groupedproduct_form', array(
                                                                   'legend' => Mage::helper('groupedproduct')->__('Set Information')
                                                              ));
        $fieldset->addField('attribute_set_name', 'text', array(
                                                               'label'     => Mage::helper('groupedproduct')->__('Set'),
                                                               'note'      => 'Prefixing admin set name with origin is optional.',
                                                               'class'     => 'required-entry',
                                                               'required'  => true,
                                                               'name'      => 'attribute_set_name',
                                                               'disabled'  => true
                                                          ));

        $disabled = !$this->_isAllowedAction('save');

        if ($disabled) {
            $multiSelectClass = '';
        } else {
            $multiSelectClass = 'levementum-ordered-multiselect';
        }

        $displayedAttributes = $fieldset->addField('attribute_codes', 'multiselect', array(
                                                                   'label'     => Mage::helper('groupedproduct')->__('Frontend Set Name'),
                                                                   'note'      => 'This overrides system configuration settings.  This is overwritten by product selections.  If this is left blank system configuration is used.',
                                                                   'class'     => $multiSelectClass,
                                                                   'required'  => false,
                                                                   'name'      => 'attribute_codes',
                                                                   'values'    => $this->getAttributeCodes($data['attribute_codes']),
                                                                   'disabled'  => $disabled
                                                              ));
        $primaryAttributes = $fieldset->addField('primary_attribute', 'select', array(
                                                                   'label'     => Mage::helper('groupedproduct')->__('Primary Attribute'),
                                                                   'note'      => 'The selected column will expand to fill the space, all others will be "minimized"',
                                                                   'required'  => false,
                                                                   'name'      => 'primary_attribute',
                                                                   'disabled'  => $disabled,
                                                              ));

        $fieldset->addField('is_active', 'select', array(
                                                        'name'     => 'is_active',
                                                        'note'     => 'This set will not be used if inactive.',
                                                        'label'    => Mage::helper('catalog')->__('Is Active'),
                                                        'values'   => $setsSource,
                                                        'disabled' => $disabled
                                                   ), 'is_active');

        $form->setValues($data);

        $displayedAttributesId = $displayedAttributes->getHtmlId();
        $primaryAttributesId = $primaryAttributes->getHtmlId();

        $afterHtml = Mage::helper('groupedproduct/admin')
            ->getPrimaryAttributeAfterHtml($displayedAttributesId,$primaryAttributesId,$primaryAttributes->getEscapedValue());

        $primaryAttributes->setAfterElementHtml($afterHtml);

        return parent::_prepareForm();
    }

    protected function getAttributeCodes($currentOptions)
    {

        return Mage::getSingleton('groupedproduct/system_config_source_attributes')->toOptionArray($currentOptions);
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