<?php
include("../main/cons/config.php");
?>
<!doctype html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="empModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Info</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <table border='1' style='border-collapse: collapse;'>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>&nbsp;</th>
            </tr>
            <?php
            $query = "select * from employee";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $name = $row['emp_name'];
                $email = $row['email'];

                echo "<tr>";
                echo "<td>" . $name . "</td>";
                echo "<td>" . $email . "</td>";
                echo "<td><button data-id='" . $id . "' class='userinfo'>Info</button></td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>
</body>
<script>
    $(document).ready(function() {

        $('.userinfo').click(function() {

            var userid = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'ajaxfile.php',
                type: 'post',
                data: {
                    userid: userid
                },
                success: function(data) {
                    // Add response in Modal body
                    $('.modal-body').html(data);

                    // Display Modal
                    $('#empModal').modal('show');
                }
            });
        });
    });
</script>

</html>