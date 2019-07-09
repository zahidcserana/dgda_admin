var DatatableRemoteAjaxDemo = function () {
    // basic demo
    var demo = function () {

        var datatable = $('.m_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        // sample GET method
                        method: 'GET',
                        url: "/orders/item-list",
                        map: function (raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false
            },

            // column sorting
            sortable: true,

            pagination: true,

            toolbar: {
                // toolbar items
                items: {
                    // pagination
                    pagination: {
                        // page size select
                        pageSizeSelect: [10, 20, 30, 50, 100],
                    },
                },
            },

            search: {
                input: $('#generalSearch'),
            },

            // columns definition
            columns: [
                {
                    field: 'RecordID',
                    title: '#',
                    sortable: false, // disable sort for this column
                    width: 40,
                    selector: false,
                    textAlign: 'center',
                }, {
                    field: 'pharmacy_branch',
                    title: 'Pharmacy Branch',
                }, {
                    field: 'company_invoice',
                    title: 'Invoice',
                }, {
                    field: 'medicine',
                    title: 'Medicine',
                }, {
                    field: 'company',
                    title: 'Company',
                }, {
                    field: 'batch_no',
                    title: 'Batch No',
                }, {
                    field: 'quantity',
                    title: 'Quantity',
                }, {
                    field: 'mfg_date',
                    title: 'MFG Date',
                    type: 'date',
                    format: 'MM/DD/YYYY',
                }, {
                    field: 'exp_date',
                    title: 'EXP Date',
                }, {
                    field: 'status',
                    title: 'Status',
                    // callback function support for column rendering
                    template: function (row) {
                        var status = {
                            'RETURNED': {'title': 'RETURNED', 'class': 'm-badge--brand'},
                            'SOLD': {'title': 'SOLD', 'class': 'm-badge  m-badge--danger m-badge--wide'},
                            'REMOVED': {'title': 'REMOVED', 'class': 'm-badge--brand'},
                            'OK': {'title': 'OK', 'class': 'm-badge  m-badge--metal m-badge--wide'},
                        };
                        return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                    },
                },
            ],
        });

        $('#m_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'status');
        });

        $('#m_form_company_invoice').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'company_invoice');
        });

        $('#m_form_medicine').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'medicine');
        });

        $('#m_form_id').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'id');
        });

        $('#m_form_status, #m_form_type').selectpicker();

    };

    return {
        // public functions
        init: function () {
            demo();
        },
    };
}();

jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init();
});
