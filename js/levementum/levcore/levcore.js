/**
 * User: Ian
 * Date: 8/31/12
 * Time: 10:44 AM
 */


jQuery(document).ready(function () {
    (function($){
        var multiselectCallbacks = {
            oldSetSelect: $.ui.multiselect.prototype._setSelected,
            _setSelected: function(item, selected){
                this.oldSetSelect(item, selected);
                if (typeof this.options.onChangeCallback == 'function') {
                    this.options.onChangeCallback.call(this);
                }
                $(this.element).trigger('change');
            }
        };
        $.extend($.ui.multiselect.prototype, multiselectCallbacks);
    })(jQuery);

    // choose either the full version
    jQuery(".levementum-ordered-multiselect > .multiselect,.levementum-ordered-multiselect.multiselect").multiselect();
    // or disable some features
    // jQuery(".multiselect").multiselect({sortable: false, searchable: false});


});

function divToggle(details, switcher, expandedClassName)
{
    if ($(details).style.display == 'none') {
        $(details).show();
        $(switcher).addClassName(expandedClassName);
    } else {
        $(details).hide();
        $(switcher).removeClassName(expandedClassName);
    }
}

function toggleCustomPrice(checkbox, elemId, tierBlock) {
    if (checkbox.checked) {
        $(elemId).disabled = false;
        $(elemId).show();
        if($(tierBlock)) $(tierBlock).hide();
    } else {
        $(elemId).disabled = true;
        $(elemId).hide();
        if($(tierBlock)) $(tierBlock).show();
    }
}

function xorCheck(a, b){
    return(( a && !b ) || (!a && b));
}

/**
 * Checkbox Radio toggle fields.  Only the box with the corresponding checkbox can be displayed.
 * Makes two checkboxes behave as radio buttons for displaying an input field,
 */

function checkboxRadiToggleField(checkbox1,checkbox1Block,checkbox2,checkbox2Block) {
    var bothValid = false;
    var boxes = {
        1:{
            elm  :$(checkbox1),
            block:$(checkbox1Block)
        },
        2:{
            elm  :$(checkbox2),
            block:$(checkbox2Block)
        }
    };

    $H(boxes).each(function (pair) {
        if (pair.value.elm) {
            pair.value.elm.observe('click', function (pair, event) {
                var boxNumber = pair[0];
                var box = pair[1];
                var otherBox = boxes[Number(boxNumber) % 2 + 1];

                disableBox(otherBox);

                toggleCustomPrice(box.elm, box.block.readAttribute('id'));
            }.bind(this, pair));
        }
    });

    function enableBox(box) {
        if (!box.elm || !box.block) {
            return;
        }
        box.elm.checked = true;
        box.block.disabled = false;
        box.block.show();
    }

    function disableBox(box) {
        if (!box.elm || !box.block) {
            return;
        }
        box.elm.checked = false;
        box.block.disabled = true;
        box.block.hide();
    }
}