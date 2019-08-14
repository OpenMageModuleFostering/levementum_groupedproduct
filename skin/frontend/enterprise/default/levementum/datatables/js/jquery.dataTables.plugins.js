/**
 * User: Ian
 * Date: 5/21/12
 * Time: 1:41 PM
 * This file must be included after dataTables.js
 */
jQuery.fn.dataTableExt.oSort['currency-asc'] = function (a, b) {
    'use strict';

    var x, y;

    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    x = (a === "-" || a === "--" || a === '' || a.toLowerCase().replace('/', '') === 'na') ? -1 : a.replace(/,/g, "");
    y = (b === "-" || b === "--" || b === '' || b.toLowerCase().replace('/', '') === 'na') ? -1 : b.replace(/,/g, "");

    /* Remove the currency sign */
    if (typeof x === "string" && isNaN(x.substr(0, 1), 10)) {
        x = x.substring(1);
    }
    if (typeof y === "string" && isNaN(y.substr(0, 1), 10)) {
        y = y.substring(1);
    }

    /* Parse and return */
    x = parseFloat(x, 10);
    y = parseFloat(y, 10);

    return x - y;
};
jQuery.fn.dataTableExt.oSort['currency-desc'] = function (a, b) {
    'use strict';

    var x, y;

    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
    x = (a === "-" || a === "--" || a === '' || a.toLowerCase().replace('/', '') === 'na') ? -1 : a.replace(/,/g, "");
    y = (b === "-" || b === "--" || b === '' || b.toLowerCase().replace('/', '') === 'na') ? -1 : b.replace(/,/g, "");

    /* Remove the currency sign */
    if (typeof x === "string" && isNaN(x.substr(0, 1), 10)) {
        x = x.substring(1);
    }
    if (typeof y === "string" && isNaN(y.substr(0, 1), 10)) {
        y = y.substring(1);
    }

    /* Parse and return */
    x = parseFloat(x, 10);
    y = parseFloat(y, 10);

    return y - x;
};

/*Inches in format 1", 1-1/8", 1/8" or 16*/
jQuery.fn.dataTableExt.oSort['dimension-asc'] = function (a, b) {
    'use strict';

    var x = a.toLowerCase(), y = b.toLowerCase();

    /** Process x**/
    //If it is not numeric, we need to process, if it is...already done!
    if (!jQuery.isNumeric(x)) {
        /*remove any "*/
        x = x.replace('"', '');

        if (!jQuery.isNumeric(x)) {
            /*Search for format 1-1/8*/
            var slashFound = false;
            for (var i = 0; i < x.length; ++i) {
                /*A "-" will be found first.*/
                if (x.charAt(i) == '-') {
                    for (var j = i + 1; j < x.length; ++j) {
                        if (x.charAt(j) == '/') {
                            var arr = x.split("-");
                            var arr2 = arr[1].split("/");
                            x = parseFloat(arr[0], 10) + parseFloat(arr2[0], 10) / parseFloat(arr2[1], 10);
                            slashFound = true;
                            break;
                        }
                    }

                    /*If slash was found, we don't need to process /*/
                    if (slashFound) {
                        break;
                    }
                } else if (x.charAt(i) == '/') {
                    var arr = x.split("/");
                    x = parseFloat(arr[0], 10) / parseFloat(arr[1], 10);
                    slashFound = true;
                }
            }

            if (!slashFound) {
                x = 0;
            }
        }
    }
    /** End Process x**/

    /** Process y**/
    /*If it is not numeric, we need to process, if it is...already done!*/
    if (!jQuery.isNumeric(y)) {
        /*remove any "*/
        y = y.replace('"', '');

        if (!jQuery.isNumeric(y)) {
            /*Search for format 1-1/8*/
            var slashFound = false;
            for (var i = 0; i < y.length; ++i) {
                /*A "-" will be found first.*/
                if (y.charAt(i) == '-') {
                    for (var j = i + 1; j < y.length; ++j) {
                        if (y.charAt(j) == '/') {
                            var arr = y.split("-");
                            var arr2 = arr[1].split("/");
                            y = parseFloat(arr[0], 10) + parseFloat(arr2[0], 10) / parseFloat(arr2[1], 10);
                            slashFound = true;
                            break;
                        }
                    }

                    /*If slash was found, we don't need to process /*/
                    if (slashFound) {
                        break;
                    }
                } else if (y.charAt(i) == '/') {
                    var arr = y.split("/");
                    y = parseFloat(arr[0], 10) / parseFloat(arr[1], 10);
                    slashFound = true;
                }
            }

            if (!slashFound) {
                y = 0;
            }
        }
    }
    /** End Process y**/

    /* Parse and return */
    x = parseFloat(x, 10);
    y = parseFloat(y, 10);

    return x - y;

};

/*Inches in format 1", 1-1/8", 1/8" or 16*/
jQuery.fn.dataTableExt.oSort['dimension-desc'] = function (a, b) {
    'use strict';

    var x = a.toLowerCase(), y = b.toLowerCase();

    if (x == '3/16"') {
        x = x;
    }
    /** Process x**/
    /*If it is not numeric, we need to process, if it is...already done!*/
    if (!jQuery.isNumeric(x)) {
        /*remove any "*/
        x = x.replace('"', '');

        if (!jQuery.isNumeric(x)) {
            /*Search for format 1-1/8*/
            var slashFound = false;
            for (var i = 0; i < x.length; ++i) {
                /*A "-" will be found first.*/
                if (x.charAt(i) == '-') {
                    for (var j = i + 1; j < x.length; ++j) {
                        if (x.charAt(j) == '/') {
                            var arr = x.split("-");
                            var arr2 = arr[1].split("/");
                            x = parseFloat(arr[0], 10) + parseFloat(arr2[0], 10) / parseFloat(arr2[1], 10);
                            slashFound = true;
                            break;
                        }
                    }

                    /*If slash was found, we don't need to process /*/
                    if (slashFound) {
                        break;
                    }
                } else if (x.charAt(i) == '/') {
                    var arr = x.split("/");
                    x = parseFloat(arr[0], 10) / parseFloat(arr[1], 10);
                    slashFound = true;
                }
            }

            if (!slashFound) {
                x = 0;
            }
        }
    }
    /** End Process x**/

    /** Process y**/
    /*If it is not numeric, we need to process, if it is...already done!*/
    if (!jQuery.isNumeric(y)) {
        /*remove any "*/
        y = y.replace('"', '');

        if (!jQuery.isNumeric(y)) {
            /*Search for format 1-1/8*/
            var slashFound = false;
            for (var i = 0; i < y.length; ++i) {
                /*A "-" will be found first.*/
                if (y.charAt(i) == '-') {
                    for (var j = i + 1; j < y.length; ++j) {
                        if (y.charAt(j) == '/') {
                            var arr = y.split("-");
                            var arr2 = arr[1].split("/");
                            y = parseFloat(arr[0], 10) + parseFloat(arr2[0], 10) / parseFloat(arr2[1], 10);
                            slashFound = true;
                            break;
                        }
                    }

                    /*If slash was found, we don't need to process /*/
                    if (slashFound) {
                        break;
                    }
                } else if (y.charAt(i) == '/') {
                    var arr = y.split("/");
                    y = parseFloat(arr[0], 10) / parseFloat(arr[1], 10);
                    slashFound = true;
                }
            }

            if (!slashFound) {
                y = 0;
            }
        }
    }
    /** End Process y**/

    /* Parse and return */
    x = parseFloat(x, 10);
    y = parseFloat(y, 10);

    return y - x;

};


jQuery.fn.dataTableExt.oSort['size-asc'] = function (a, b) {
    'use strict';

    var x = a.match(/[0-9]+/g);
    var y = b.match(/[0-9]+/g);

    return x - y;
};

jQuery.fn.dataTableExt.oSort['size-desc'] = function (a, b) {
    'use strict';

    var x = a.match(/[0-9]+/g);
    var y = b.match(/[0-9]+/g);

    return y - x;
};

/** currency **/
jQuery.fn.dataTableExt.aTypes.push(
    function (sData) {
        var sValidChars = "0123456789.-";
        var Char;

        /* Check the numeric part */
        for (i = 1; i < sData.length; i++) {
            Char = sData.charAt(i);
            if (sValidChars.indexOf(Char) == -1) {
                return null;
            }
        }

        /* Check prefixed by currency */
        if (sData.charAt(0) == '$' || sData.charAt(0) == '£') {
            return 'currency';
        }
        return null;
    }
);

/*Inches in format 1", 1-1/8", 1/8" or 16*/
jQuery.fn.dataTableExt.aTypes.push(
    function (sData) {
        var sValidChars = "0123456789.-/\"";
        var Char;

        /* Check the numeric part */
        for (i = 1; i < sData.length; i++) {
            Char = sData.charAt(i);
            if (sValidChars.indexOf(Char) == -1) {
                return null;
            }
        }

        if (jQuery.isNumeric(sData.charAt(0)) || sData.charAt(sData.length - 1) == '"') {
            return 'dimension';
        }
        return null;
    }
);

/** size **/
/* Size format, "5 mL" OR "14 mL"  OR "14 mL." */
jQuery.fn.dataTableExt.aTypes.push(
    function (sData) {
        var sValidChars = "0123456789\ mMlL\.";
        var Char;

        /* Check the numeric part */
        for (i = 1; i < sData.length; i++) {
            Char = sData.charAt(i);
            if (sValidChars.indexOf(Char) == -1) {
                return null;
            }
        }

        if (sData == '5 ml.') {
            sData = sData;
        }
        var size = sData.match(/[0-9]+/g);
        if (/[0-9]+[\ ]+[m][L|l][\.]?/.test(sData) && size.length == 1) {
            return 'size';
        }

        return null;
    }
);


jQuery.fn.dataTableExt.aTypes.reverse();