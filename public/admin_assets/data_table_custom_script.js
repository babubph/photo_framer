$(function () {
    $("#example1").DataTable({
      "ordering": false,
      "lengthMenu": [25, 50, 100, 150, "All"],
      "fixedHeader": true,
      "responsive": false,
      "lengthChange": false,
      "autoWidth": false,
      "bPaginate": true, // Show pagination
      "bFilter": true, // Show search bar
      "bInfo": false, // Hide showing entries info
      dom: 'Bfrtip',
      buttons: [
        { extend: 'copyHtml5', footer: true },
        { extend: 'excelHtml5', footer: true },
        { extend: 'csvHtml5', footer: true },
        { extend: 'pdfHtml5', footer: true },
        { extend: 'print', footer: true },
        'pageLength'
      ],
      lengthMenu: [
        [25, 50, 100, 150, -1],
        ['25 rows', '50 rows', '100 rows', '150 rows', 'Show all']
      ],
      initComplete: function() {
        var input = $('.dataTables_filter input');
        input.attr('placeholder', 'keyword...'); 
         // Change the label text of the search input
         $('.dataTables_filter label').contents().filter(function () {
                 return this.nodeType === 3; // Node type 3 is a text node
             }).each(function () {
                 this.textContent = 'Custom Keyword Search: '; // Set custom label text
             });
      }
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
 });
 
 