<?php
/**
 * User: icoast@levementum.com
 * Date: 11/12/12 3:19 PM
 */

class Levementum_LevCore_Block_Adminhtml_Widget_Grid_Column_Renderer_Nowrap extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{


    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $line = parent::_getValue($row);
        return '<span class="nobr">'.$line.'</span>'.print_r($row->getData(),true);
    }
}