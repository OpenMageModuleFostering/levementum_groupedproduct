<?php

/**
 * User: ian.c
 * Date: 11/30/12 1:59 PM
 */
class Levementum_Groupedproduct_Block_Catalog_Form_Renderer_Fieldset_Primary
    extends Varien_Data_Form_Element_Text
{
    /**
     * Retrieve Element HTML fragment
     *
     * @return string
     */
    public function getElementHtml()
    {
        $afterHtml = Mage::helper('groupedproduct/admin')
            ->getPrimaryAttributeAfterHtml('lev_displayed_attributes','lev_primary_attribute',$this->getEscapedValue());

        $this->addClass('select');

        $html = '<select id="'.$this->getHtmlId().'" name="'.$this->getName().'" '.$this->serialize($this->getHtmlAttributes()).'>'."\n";

        $html .= '</select>'."\n";
        $html .= $this->getAfterElementHtml();
        $html .= $afterHtml;

        return $html;
    }
}