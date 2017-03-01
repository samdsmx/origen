function evaluaSentence(subexp) {
    var obj_op_val = [];
    var flag = 0;
    obj_op_val[flag] = "";
    for (var k = 0; k < subexp.length; k++) {
        if (subexp[k] !== '"') {
            obj_op_val[flag] += subexp[k];
            if (subexp[k] === ' ' && flag < 2) {
                obj_op_val[flag] = obj_op_val[flag].trim();
                flag++;
                obj_op_val[flag] = "";
            }
        }
    }
    var val;
    var elements = document.querySelectorAll('[id^="input' + obj_op_val[0] + '"]');
    for (var e = 0; e < elements.length; e++) {
        if (($(elements[e]).prop('type') === 'radio' || $(elements[e]).prop('type') === 'checkbox') && !$(elements[e]).prop('checked')) {
            continue;
        }
        var valAct = $(elements[e]).val();
        switch (obj_op_val[1]) {
            case "=":
                val = (valAct == obj_op_val[2]);
                break;
            case "<>":
                val = (valAct != obj_op_val[2]);
                break;
            case ">":
                val = (valAct > obj_op_val[2]);
                break;
            case ">=":
                val = (valAct >= obj_op_val[2]);
                break;
            case "<":
                val = (valAct < obj_op_val[2]);
                break;
            case "<=":
                val = (valAct <= obj_op_val[2]);
                break;
            case "like":
                val = valAct.match(RegExp(obj_op_val[2]));
                val = (val[0].length > 0);
                break;
            case "is":
                val = (valAct.length === 0);
                break;
            case "not":
                val = (valAct.length > 0);
                break;
            default:
                val = false;
                break;
        }
        if (val) {
            return 1;
        }
    }
    return 0;
}

function evaluaBool(subexp) {
    var val = 0;
    var op = 0;
    for (var k = 0; k < subexp.length; k++) {
        switch (subexp[k]) {
            case 'T':
                val = ((op === 0) ? (val | 1) : (val & 1));
                break;
            case 'F':
                val = ((op === 0) ? (val | 0) : (val & 0));
                break;
            case 'y':
                op = 1;
                break;
            case 'o':
                op = 0;
                break;
        }
    }
    return val;
}

function evaluaParentesis(exp) {
    var start = -1;
    var end = -1;
    for (var k = 0; k < exp.length && end === -1; k++) {
        if (exp[k] === '(') {
            start = k;
        }
        if (exp[k] === ')') {
            end = k;
        }
    }
    if (start !== -1 && end !== -1) {
        var subexp = exp.substring(start + 1, end);
        var val;
        if (subexp[0] === 'Q') {
            val = evaluaSentence(subexp);
        }
        else {
            val = evaluaBool(subexp);
        }
        exp = exp.replace("(" + subexp + ")", (val === 1 ? "T" : "F"));
    }
    else {
        val = evaluaBool(exp);
        exp = (val === 1 ? "T" : "F");
    }
    return exp;
}

function evalua(id, exp) {
    do {
        exp = evaluaParentesis(exp);
    } while (exp.length > 1);
    if (exp === "T") {
        $("#div" + id).show();
    }
    else {
        $("#div" + id).hide();
    }
    renumera();
}

function detectaCambio(i) {
    var elements = document.querySelectorAll('[id^="hidQ"]');
    var exp, id;
    for (var e = 0; e < elements.length; e++) {
        exp = String(elements[e].value);
        id = String(elements[e].id).substr(3);
        if (i === null || exp.search("Q" + i + " ") !== -1) {
            evalua(id, exp);
        }
    }
}

function renumera() {
    var numeracion = 1;
    var elements = document.querySelectorAll('[id^="labelP"]');
    var s;
    for (var e = 0; e < elements.length; e++) {
        if ($(elements[e]).is(":visible")) {
            s = $(elements[e]).html();
            $(elements[e]).html(numeracion + s.substr(s.indexOf(")")));
            numeracion++;
        }
    }
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
    detectaCambio(null);
    renumera();
});

$(document).ready(function() {
    detectaCambio(null);
    renumera();
    $(".chosen-select").chosen({
        no_results_text: "Oops, opción no encontrada!",
        allow_single_deselect: true,
        width: '100%'
    });
});
