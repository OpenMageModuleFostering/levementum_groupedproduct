<?php
/**
 * User: ian.c
 * Date: 10/12/12 4:02 PM
 */
/** @var $this Levementum_Groupedproduct_Model_Entity_Setup_Model_Entity_Setup */

//0. get entity type id
$entityTypeId = $this->getEntityTypeId('catalog_product');

//1. capture attribute sets
/** @var $attributeSets Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection */
$attributeSets = Mage::getModel('eav/entity_attribute_set')->getCollection()->addFieldToFilter('entity_type_id',$entityTypeId);

foreach ($attributeSets as $attributeSet) {
    $model = Mage::getModel('groupedproduct/sets');
    $model->setSetId($attributeSet->getId())->save();
}