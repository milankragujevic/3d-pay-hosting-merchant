// noinspection JSValidateTypes
$(document).ready(function () {
    // noinspection ES6ConvertVarToLetConst
    var table = new Table('#shopping-cart-items');
    // noinspection ES6ConvertVarToLetConst
    var orderByColumns = [2];
    // noinspection ES6ConvertVarToLetConst
    var fixedColumns = [0, 6];
    table.renderTable(orderByColumns, fixedColumns);
});