$(document).ready(function() {
    $('#example').DataTable();
})  

new DataTable('#example', {
    lengthMenu: [
        [35, 10, 25, 50, -1],
        [35, 10, 25, 50, 'All']
    ]
});