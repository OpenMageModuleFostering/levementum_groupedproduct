<?php
/**
 * User: ian.c
 * Date: 7/2/12 8:45 AM
 * File: Collection.php
 */

Class Levementum_Groupedproduct_Model_Resource_Sets_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    public function _construct() {
        $this->_init('groupedproduct/sets');
    }

    public function delete()
    {
        foreach ($this->getItems() as $k=>$item) {
            $item->delete();
            unset($this->_items[$k]);
        }
        return $this;
    }

    public function getAllSetIds()
    {
        $setIds = array();
        foreach ($this->getItems() as $set) {
            $setIds[$set->getSetId()] = $set->getSetId();
        }

        return $setIds;
    }
}