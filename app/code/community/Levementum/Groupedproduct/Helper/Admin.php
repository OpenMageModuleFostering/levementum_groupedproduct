<?php
/**
 * User: icoast@levementum.com
 * Date: 11/30/12 4:44 PM
 */

class Levementum_Groupedproduct_Helper_Admin extends Mage_Core_Helper_Abstract {
    //$this->getEscapedValue()
    public function getPrimaryAttributeAfterHtml($displayedAttributesId = 'lev_displayed_attributes',
                                                 $primaryAttributeValId = 'lev_primary_attribute',
                                                 $escapedValue = ''
    )
    {
        $afterHtml = '

            <input type="hidden" id="'.$primaryAttributeValId.'_val" value="'.$escapedValue.'" />
            <script type="text/javascript">
            var levDisplayedAttributes;
            var levPrimaryAttribute;
            (function($) {  
                $(document).ready(function() {
                    levDisplayedAttributes = $("#'.$displayedAttributesId.'");
                    levPrimaryAttribute = $("#'.$primaryAttributeValId.'");
    
                    levUpdatePrimaryAttribute();
    
                    //load initial selection
                    levPrimaryAttribute.val($("#'.$primaryAttributeValId.'_val").val());
    
                    $(levDisplayedAttributes).change(function() {
                        levUpdatePrimaryAttribute();
                    });
                });

                function levUpdatePrimaryAttribute() {
                    var levDisplayedAttributesSelected = $("#'.$displayedAttributesId.' option:selected");
                    var levPrimaryAttributeVal = levPrimaryAttribute.val();
    
                    levPrimaryAttribute.empty();
                    levPrimaryAttribute.append($("<option></option>"));
    
                    //populate with current selected
                    levDisplayedAttributesSelected.each(function() {
                        var element = $(this);
                        levPrimaryAttribute.append($("<option></option>").attr("value", element.val()).text(element.text()));
                    });
    
                    if (levPrimaryAttributeVal) {
                        levPrimaryAttribute.val(levPrimaryAttributeVal);
                    }
                }
            })(jQuery)
            </script>
        ';

        return $afterHtml;
    }
}