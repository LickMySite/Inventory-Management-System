/* Datatables custom js
* https://datatables.net/
* Used for sorting, search and pagnation for tables
*/

$(document).ready( function () {
  $('#myTable').DataTable({
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, 'All'],
    ],
  });
});

