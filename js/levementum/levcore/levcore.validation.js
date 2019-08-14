if (typeof Validation !== 'undefined') {
    Validation.addAllThese(
        [
            //validates all fields that contain the class name "exclusive-attribute"
            [
                'validate-exclusive-attribute',
                'Only one of these values may selected.',
                function (v, elm) {
                    var result = true;
                    var expGroupedRegEx = /exclusive-attribute-[a-zA-Z][a-zA-Z0-9_]*/; //checks for "exclusive-attribute-attribute_code"
                    var match = expGroupedRegEx.exec(elm.className);
                    var currentValueIsEmpty = Validation.get('IsEmpty').test(v);
                    if (match) {
                        var attributeCode = match[0].substr(20);
                        if ($(attributeCode)) {
                            var secondValueIsEmpty = Validation.get('IsEmpty').test($(attributeCode).getValue());
                            if (currentValueIsEmpty && secondValueIsEmpty) {
                                Validation.methods['validate-exclusive-attribute'].error = 'Please enter a value in one of these fields.';
                                return false;
                            }
                            if (!(xorCheck(currentValueIsEmpty, secondValueIsEmpty))) {
                                return false;
                            }
                        }

                    }
                    $w(elm.className).each(function (name) {
                        if (name == 'exclusive-attribute') {
                            $$('.exclusive-attribute').each(function (elm) {
                                var secondValueIsEmpty = Validation.get('IsEmpty').test(elm.getValue());
                                if (!xorCheck(secondValueIsEmpty, currentValueIsEmpty)) {
                                    return false;
                                }
                            });
                        }
                    });
                    return true;
                }
            ],
            [
                'validate-date-range-closed',
                'Open-ended date range is not allowed.  Please enter both a start and end date.',
                //error code if validation fails.
                function (v, elm) {
                    var paired = new RegExp(/^date-range-pair-[a-zA-Z][a-zA-Z0-9_]*$/);

                    var result = true;
                    $w(elm.className).each(function (name, index) {
                        if (name.match(paired) && result) {
                            var pairedId = name.split('-')[3];
                            var pairedElm = $(pairedId);

                            if (pairedElm == undefined) {
                                result = false;
                                return;
                            }

                            var pairedValue = pairedElm.getValue();

                            result = !((v == '' && pairedValue != '') || (v != '' && pairedValue == ''));
                        }
                    });

                    return result;
                }
            ],
            [
                'validate-special-dates',
                'Open-ended specials are not allowed.  Please enter both a start and end date.',
                //error code if validation fails.
                function (v, elm) {
                    var specialPrice = $('special_price').getValue();

                    //if no special price, no need to check further.
                    if (specialPrice <= 0 || specialPrice == '') {
                        return true;
                    }

                    var id = elm.readAttribute('id');
                    var otherId = false;
                    if (id == 'special_from_date') {
                        otherId = 'special_to_date';
                    } else {
                        otherId = 'special_from_date';
                    }

                    //if they aren't both here, just pass it.
                    if ($(id) == undefined || $(otherId) == undefined) {
                        return true;
                    }
                    elm.addClassName('date-range-pair-' + otherId);

                    return Validation.get('validate-date-range-closed').test(v, elm);
                }
            ]
        ])
}

