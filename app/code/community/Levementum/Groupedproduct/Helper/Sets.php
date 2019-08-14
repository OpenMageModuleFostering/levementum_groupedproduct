<?php
/**
 * User: icoast@levementum.com
 * Date: 1/10/13 5:18 PM
 * File: Sets.php
 */

class Levementum_Groupedproduct_Helper_Sets extends Mage_Core_Helper_Abstract {
    /**
     * Sync any new sets into the grouped set.  Code assumes sets may not be in the table, that's ok.
     *
     * This also allows for sets to be added in other ways such as custom import/export script people may have.
     */
    public function syncAttributeSets()
    {
        //load current grouped sets
        /** @var $groupedproductCollection Levementum_Groupedproduct_Model_Resource_Sets_Collection */
        $groupedproductCollection = Mage::getModel('groupedproduct/sets')->getCollection();
        $setIds = $groupedproductCollection->getAllSetIds();

        $entityType = Mage::getModel('eav/config')->getEntityType(Mage_Catalog_Model_Product::ENTITY);
        $entityTypeId = $entityType->getEntityTypeId();

        /** @var $attributeSets Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection */
        $attributeSets = Mage::getModel('eav/entity_attribute_set')
            ->getCollection()
            ->addFieldToFilter('entity_type_id',$entityTypeId)
            ->addFieldToFilter('attribute_set_id',array('nin'=>$setIds));

        foreach ($attributeSets as $attributeSet) {
            $model = Mage::getModel('groupedproduct/sets');
            $model->setSetId($attributeSet->getId())->save();
        }
    }
}