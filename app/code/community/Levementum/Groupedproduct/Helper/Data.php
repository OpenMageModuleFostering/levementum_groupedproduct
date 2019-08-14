<?php
/**
 * User: ian.c
 * Date: 5/9/12 2:09 PM
 * File: Data.php
 * To change this template use File | Settings | File Templates.
 */
class Levementum_Groupedproduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    /** @var $_configHelper Levementum_Groupedproduct_Helper_Config */
    protected $_configHelper;

    protected $_options = array();
    protected $_optionsArray = array();
    protected $_attributeId;
    protected $_attributes;

    public function __construct()
    {
        $this->_configHelper = Mage::helper('groupedproduct/config');

        $this->_attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'lev_displayed_attributes');
        $this->_options     = Mage::getModel('eav/entity_attribute')->load($this->_attributeId)->getSource()->getUnprocessedOptions();

        $this->_optionsArray = array();
        foreach ($this->_options as $option) {
            $this->_optionsArray[$option['label']] = $option['value'];
        }

        $this->_attributes = Mage::getSingleton('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getAttributeCollection();
    }

    /**
     * @param array $excludeAttr
     *
     * @return array
     */
    public function getAdditionalData(array $excludeAttr = array())
    {
        $unsorted_value = 1000;
        $data           = array();

        /** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
        foreach ($this->_attributes as $attribute) {
            if ($this->_configHelper->allowAllAttributes() || ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr))) {
                if (!in_array($attribute->getAttributeCode(), $excludeAttr)) {
                    $label = $attribute->getStoreLabel();
                    if (!empty($label)) {
                        $label = substr($label, 0, 40);

                        $data[$attribute->getAttributeCode()] = array(
                            'label'            => $label,
                            'value'            => $attribute->getAttributeCode(),
                            'code'             => $attribute->getAttributeCode(),
                            'used_for_sort_by' => $attribute->getUsedForSortBy(),
                            'sorted_value'     => $unsorted_value++,
                            'primary'          => false
                        );
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $displayedAttributes
     * @param null|Mage_Catalog_Model_Product  $_product
     * @param bool $fromSortBy
     *
     * @return array
     */
    public function getDisplayedAttributeList($displayedAttributes = array(), $_product = null, $fromSortBy = false)
    {
        //See if product is defined and try to get those displayed attributes.
        $set = false;
        if ($this->isEmpty($displayedAttributes) && !empty($_product)) {
            if ($setId = $_product->getAttributeSetId()) {
                /** @var $set Levementum_Groupedproduct_Model_Sets */
                //load by set id
                $set = Mage::getSingleton('groupedproduct/sets')->reset()->load($setId, 'set_id');

                //if it exists, see if there are any defined.
                if ($set->getId() && $set->isActive()) {
                    $displayedAttributes = $set->getAttributeCodes();
                }
            }
        }

        //If it is empty try to get default.
        if ($this->isEmpty($displayedAttributes)) {
            $displayedAttributes = $this->_configHelper->getDefaultDisplayedAttributes();
        }

        //if it is still empty, exit.
        if ($this->isEmpty($displayedAttributes)) {
            return array();
        }

        //If it is not an array, make it so.
        if (!is_array($displayedAttributes)) {
            $displayedAttributes = explode(',', $displayedAttributes);
        }

        $allAttributes = $this->getAdditionalData();
        $attributes    = array();

        $productPrimaryCode = false;
        $setPrimaryCode     = false;
        $defaultPrimaryCode = false;
        foreach ($displayedAttributes as $displayedKey => $displayed) {
            foreach ($allAttributes as $key => $attribute) {
                if ($attribute['value'] == $displayed || $attribute['code'] == $displayed) {
                    if ($fromSortBy) {
                        if ($attribute['used_for_sort_by'] == false && !$this->_configHelper->allowSortAllAttributes()) {
                            unset($displayedAttributes[$displayedKey]);
                            continue;
                        }
                    }

                    $attributes[$attribute['code']] = $allAttributes[$key];

                    if (!$defaultPrimaryCode && $this->_configHelper->getDefaultPrimaryAttribute() == $attribute['code']) {
                        $defaultPrimaryCode = $attribute['code'];
                    }

                    if (!$setPrimaryCode && $set && $set->getPrimaryAttribute() == $attribute['code']) {
                        $setPrimaryCode = $attribute['code'];
                    }

                    if (!$productPrimaryCode && $_product && $_product->getLevPrimaryAttribute() == $attribute['code']) {
                        $productPrimaryCode = $attribute['code'];
                    }

                    //We've found it, don't need to continue searching.
                    break; //break one level
                }
            }
        }

        if ($productPrimaryCode && isset($attributes[$productPrimaryCode])) {
            $attributes[$productPrimaryCode]['primary'] = true;
        } elseif ($setPrimaryCode && isset($attributes[$setPrimaryCode])) {
            $attributes[$setPrimaryCode]['primary'] = true;
        } elseif ($defaultPrimaryCode && isset($attributes[$defaultPrimaryCode])) {
            $attributes[$defaultPrimaryCode]['primary'] = true;
        }

        return $attributes;
    }

    /**
     * @param null|array|string $displayedAttributes
     *
     * @return bool
     */
    protected function isEmpty($displayedAttributes)
    {
        return (empty($displayedAttributes) || (!is_array($displayedAttributes) && substr_count($displayedAttributes, ',') == strlen($displayedAttributes)));
    }

    /**
     * @param $mode string list/detail
     *
     * @return string
     */
    public function getToolbarSDom($mode)
    {
        return $this->getToolbarPositionSDom($mode, 'top').'rt'.$this->getToolbarPositionSDom($mode, 'bottom').'<"clear">';
    }

    /**
     * @param $mode     string list/detail
     * @param $position string top/bottom
     *
     * @return string
     */
    protected function getToolbarPositionSDom($mode, $position)
    {
        $pagination = '';
        $limiter = '';
        $information = '';

        $informationConfig = $this->_configHelper->getToolbarDisplayMode($mode, 'information');
        if ($informationConfig == $position || $informationConfig == 'both') {
            $information = 'i';
        }

        $limiterConfig = $this->_configHelper->getToolbarDisplayMode($mode, 'limiter');
        if ($limiterConfig == $position || $limiterConfig == 'both') {
            $limiter = 'l';

            //Pagination can only be displayed if the limiter is displayed.
            $paginationConfig = $this->_configHelper->getToolbarDisplayMode($mode, 'pagination');
            if ($paginationConfig == $position || $paginationConfig == 'both') {
                $pagination = 'p';
            }
        }

        if (empty($information) && empty($pagination) && empty($limiter)) {
            return '';
        } else {
            return '<"dataTable-'.$position.'"'.$information.$pagination.$limiter.'>';
        }
    }

    public function getPriceLabel()
    {
        return Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'price')->getStoreLabel();
    }

    /**
     * @param $simpleProduct int|Mage_Catalog_Model_Product
     *
     * @return bool|Mage_Catalog_Model_Product
     */
    public function getGroupedProductFromSimple($simpleProduct)
    {
        $groupedParentIds = $this->getGroupedProductIdsFromSimple($simpleProduct);

        if (empty($groupedParentIds)) {
            return false;
        }

        if (is_array($groupedParentIds)) {
            //find the first grouped product it is apart of.
            foreach ($groupedParentIds as $id) {
                $groupedParentId = $id;
                break;
            }
        }

        return Mage::getModel('catalog/product')->load($groupedParentId);
    }

    /**
     * @param $simpleProduct
     *
     * @return array
     */
    public function getGroupedProductIdsFromSimple($simpleProduct)
    {
        if (is_numeric($simpleProduct)) {
            $simpleProduct = Mage::getModel('catalog/product')->load($simpleProduct);
        }

        if (!($simpleProduct instanceof Mage_Catalog_Model_Product)
            || !$simpleProduct->getId()
            || $simpleProduct->getTypeId() != 'simple'
        ) {
            return array();
        }

        $groupedProductModel = Mage::getModel('catalog/product_type_grouped');

        return $groupedProductModel->getParentIdsByChild($simpleProduct->getId());
    }
}
