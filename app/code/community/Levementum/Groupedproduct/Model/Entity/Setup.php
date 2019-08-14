<?php


/**
 * EAV Entity Setup Model
 * @category   Mage
 * @package    Mage_Eav
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Levementum_Groupedproduct_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{
    /**
     * Prepare attribute values to save
     *
     * @param array $attr
     *
     * @return array
     */
    protected function _prepareValues($attr)
    {
        $data = array(
            'backend_model'            => $this->_getValue($attr, 'backend'),
            'backend_type'             => $this->_getValue($attr, 'type', 'varchar'),
            'backend_table'            => $this->_getValue($attr, 'table'),
            'frontend_model'           => $this->_getValue($attr, 'frontend'),
            'frontend_input'           => $this->_getValue($attr, 'input', 'text'),
            'frontend_label'           => $this->_getValue($attr, 'label'),
            'frontend_class'           => $this->_getValue($attr, 'frontend_class'),
            'source_model'             => $this->_getValue($attr, 'source'),
            'is_visible'               => $this->_getValue($attr, 'visible',1),
            'is_required'              => $this->_getValue($attr, 'required', 1),
            'is_user_defined'          => $this->_getValue($attr, 'user_defined', 0),
            'default_value'            => $this->_getValue($attr, 'default'),
            'is_unique'                => $this->_getValue($attr, 'unique', 0),
            'note'                     => $this->_getValue($attr, 'note'),
            'is_global'                => $this->_getValue($attr, 'global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL),
            'is_filterable'            => $this->_getValue($attr, 'filterable', 0),
            'is_filterable_in_search'  => $this->_getValue($attr, 'is_filterable_in_search', 0),
            'is_configurable'  => $this->_getValue($attr, 'configurable', 0),
            'used_in_product_listing'  => $this->_getValue($attr, 'used_in_product_listing', 1),
            'frontend_input_renderer'  => $this->_getValue($attr, 'frontend_input_renderer'),
        );

        return $data;
    }
}
