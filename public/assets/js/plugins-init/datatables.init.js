// custom-datatables.js
(function($) {
    "use strict";

    $(function () {
        // Get the ID of the element with class 'my-table'
        var tableId = $('.my-table').attr('id');

        if (!$.fn.DataTable.isDataTable('#' + tableId)) {
            initializeDataTable(tableId);
        }
    });

    function initializeDataTable(tableId) {
        var table = $('#example').DataTable({
            createdRow: function(row, data, index) {
                $(row).addClass('selected');
            },
            language: {
                paginate: {
                    next: '<i class="fa-solid fa-angle-right"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>'
                }
            }
            // Add other DataTable options as needed
        });

        table.on('click', 'tbody tr', function() {
            var $row = table.row(this).nodes().to$();
            var hasClass = $row.hasClass('selected');
            if (hasClass) {
                $row.removeClass('selected');
            } else {
                $row.addClass('selected');
            }
        });

        table.rows().every(function() {
            this.nodes().to$().removeClass('selected');
        });

        return table;
    }

    // Example usage:
    // You can call initializeDataTable with the specific table ID if needed
    // var table1 = initializeDataTable('example');
    // var table2 = initializeDataTable('example-12');
    // Add more tables as needed

})(jQuery);
