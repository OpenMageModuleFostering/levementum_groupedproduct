<?php

if (file_exists('Levementum/Groupedproduct/Model/System/Config/Source/Datatables.php')) {
    include_once('Levementum/Groupedproduct/Model/System/Config/Source/Datatables.php');
}

class Levementum_Groupedproduct_Model_System_Config_Source_PaginationDisplay extends 
    Levementum_Groupedproduct_Model_System_Config_Source_Datatables
{
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        foreach ($options as $key => $option) {
            if ($option['value'] == 'none') {
                unset($options[$key]);
            }
        }
        
        return $options;
    }
}
