<?php

class Levementum_Groupedproduct_Block_Catalog_Form_Renderer_Fieldset_Element
    extends Varien_Data_Form_Element_Multiselect
{

    /**
     * Retrieve Element HTML fragment
     *
     * @return string
     */
    public function getElementHtml()
    {
        $html = '<div class="levementum-ordered-multiselect">';
        $html .= parent::getElementHtml();
        $html .= '</div>';

        return $html;
    }
}
