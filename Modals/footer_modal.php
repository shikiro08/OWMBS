        <!-- JavaScript Libraries -->
        <!-- JavaScript Libraries -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>


        <!-- JavaScript for Modals and DataTables -->
        <script>
            $(document).ready(function () {

                $('.viewbtn').on('click', function () {
                    $('#viewmodal').modal('show');
                    $.ajax({ //create an ajax request to display.php
                        type: "GET",
                        url: "display.php",
                        dataType: "html", //expect html to be returned                
                        success: function (response) {
                            $("#responsecontainer").html(response);
                            //alert(response);
                        }
                    });
                });

            });
        </script>


        <script>
            $(document).ready(function () {

                $('#datatableid').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search Your Data",
                    }
                });

            });
        </script>

<script>
    $(document).ready(function () {
        $('.deletebtn').on('click', function () {
            $('#deletemodal').modal('show');

            // Get the ID from the data-id attribute
            var id = $(this).data('id');

            // Log the ID to the console (optional)
            console.log('Delete button clicked for ID:', id);

            // Assign the ID to the form input field
            $('#delete_id').val(id);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.editbtn').on('click', function () {
            $('#editmodal').modal('show');

            // Get the ID from the data-id attribute
            var id = $(this).data('id');

            // Log the ID to the console (optional)
            console.log('Edit button clicked for ID:', id);

            // Use the ID as needed
            $('#update_id').val(id);

            // Fetch the data from the table row
            var $tr = $(this).closest('tr');
            var user_Id = $tr.find('td:eq(1)').text(); // Replace with the correct column index
            var amount = $tr.find('td:eq(2)').text();   // Replace with the correct column index
            var status = $tr.find('td:eq(4)').text();   // Replace with the correct column index

            // Populate the form fields
            $('#user_Id').val(user_Id);
            $('#amount').val(amount);
            $('#status').val(status);
        });
    });
</script>





        <script>
        // Set the current date as the default value for the date field
        document.getElementById('pdate').valueAsDate = new Date();
        </script>

    </body>
    </html>
