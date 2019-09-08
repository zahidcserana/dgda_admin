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
                        url: "/sales/item-list",
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
            columns: [{
                field: 'pharmacy_branch',
                title: 'Pharmacy',
            }, {
                field: 'invoice',
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
                field: 'exp_date',
                title: 'EXP Date',
            }, {
                field: 'file_name',
                title: 'Prescription',
                template: function (data) {
                    return '<a  target="_blank" href="'+data.file_name+'">show</a>';
                },
            },
            ],
        });

        $('#m_form_exp_type').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'exp_type');
        });

        $('#m_form_company_id').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'company_id');
        });
        $('#medicine_name').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'medicine_name');
        });

        $('#m_form_pharmacy_licence_no').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'pharmacy_licence_no');
        });
        $('#m_form_branch_city').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'branch_city');
        });

        $('#m_form_branch_area').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'branch_area');
        });

        $('#m_form_pharmacy').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'pharmacy');
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
