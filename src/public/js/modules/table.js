// noinspection JSUnusedGlobalSymbols
function Table(selector) {

    const PAGE_LENGTH = 10;

    // noinspection JSUnusedGlobalSymbols
    this.renderTable = function (orderByColumns, fixedColumns) {
        // noinspection ES6ConvertVarToLetConst
        var that = this;
        // noinspection JSUnresolvedFunction,ES6ConvertVarToLetConst
        var table = $(selector).DataTable({
            columnDefs: that._fixedColumns(fixedColumns),
            pageLength: PAGE_LENGTH,
            language: {
                emptyTable: "Нема података",
                info: "Приказ _START_ до _END_ од _TOTAL_ рекорда",
                infoEmpty: "Приказ 0 до 0 од 0 рекорда",
                infoFiltered: "(претрага примењена на _MAX_ рекорда)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Приказ _MENU_ рекорда",
                loadingRecords: "Учитавање...",
                processing: "Процесирање...",
                search: "Претрага:",
                zeroRecords: "Нема података",
                paginate: {
                    first: "Прва",
                    last: "Последња",
                    next: "Следећа",
                    previous: "Претхода"
                },
                aria: {
                    sortAscending: ": активирај да соритраш колону растуће",
                    sortDescending: ": активирај да соритраш колону опадајуће"
                }
            },
            lengthMenu: [
                [5, 10, 20, 50, 100, 500, 2000, -1],
                [5, 10, 20, 50, 100, 500, 2000, "Све"]
            ],
            order: that._initOrderByColumns(orderByColumns)
        });

        // noinspection JSUnresolvedFunction
        table.on('order.dt search.dt', function () {
            // noinspection JSUnresolvedFunction
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    };

    this._fixedColumns = function (fixedColumns) {
        if (typeof fixedColumns !== undefined) {
            // noinspection ES6ConvertVarToLetConst
            var data = [];
            // noinspection ES6ConvertVarToLetConst
            for (var i = 0; i < fixedColumns.length; i++) {
                data.push({
                    searchable: false,
                    orderable: false,
                    targets: fixedColumns[i]
                });
            }
            return data.length > 0 ? data : null;
        }
        return null;
    };

    this._initOrderByColumns = function (orderByColumns) {
        if (orderByColumns !== undefined) {
            return orderByColumns.length > 0 ? orderByColumns : null;
        }
        return null;
    };

}