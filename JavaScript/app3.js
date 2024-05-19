$(document).ready(function() {
    $('#example').DataTable();
})  

new DataTable('#example', {
    lengthMenu: [
        [35, 5, 10, 25, 50, 100, -1],
        [35, 5, 10, 25, 50, 100, 'All']
    ]
});