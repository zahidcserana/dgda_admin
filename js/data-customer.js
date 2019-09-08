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
                        url: "/customers/list",
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
                pageSize: 500,
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
                        pageSizeSelect: [10, 20, 30, 50, 100, 500],
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
                    field: 'order_id',
                    title: 'ID',
                }, {
                    field: 'invoice',
                    title: 'Invoice',
                }, {
                    field: 'created_at',
                    title: 'Created',
                    type: 'date',
                    format: 'MM/DD/YYYY',
                }, {
                    field: 'status',
                    title: 'Status',
                    // callback function support for column rendering
                    template: function (row) {
                        var status = {
                            'PENDING': {'title': 'PENDING', 'class': 'm-badge--brand'},
                            'HOLD': {'title': 'HOLD', 'class': 'm-badge--brand'},
                            'COMPLETE': {'title': 'COMPLETE', 'class': ' m-badge--success'},
                        };
                        return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                    },
                }, {
                    field: 'actions',
                    title: 'Actions',
                }
            ],
        });

        $('#m_form_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'status');
        });

        $('#m_form_invoice').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'invoice');
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
