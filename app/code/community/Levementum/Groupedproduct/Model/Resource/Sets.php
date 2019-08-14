<?php
/**
 * User: ian.c
 * Date: 7/2/12 8:44 AM
 * File: Groupedproduct.php
 */
class Levementum_Groupedproduct_Model_Resource_Sets extends Mage_Core_Model_Resource_Db_Abstract {
    public function _construct() {
        $this->_init('groupedproduct/sets','id');
    }
}