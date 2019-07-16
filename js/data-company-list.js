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
                      url: "/company/list",
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
              field: 'company_name',
              title: 'Name',
          }, {
              field: 'company_active_status',
              title: 'Status',
          }, ],
      });

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
