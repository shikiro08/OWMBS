<?php
include_once('db.php');
$query = "SELECT * from relay_events order by id desc";
$result = mysqli_query($conn, $query);

$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");

?>

<?php
include 'header.php';
include 'sidebar.php';
?>

    <div class="container-fluid px-4">
        <!-- Main content here -->
        <div class="container-fluid px-4">
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Valve Status</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">time</th>
                                    <th scope="col">Valve_id</th>
                                </tr>
                            </thead>
                            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['time']; ?></td>
                                    <td><?php echo $rows['valve_id']; ?></td>
                                </tr>
                            </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
include 'footer.php';
?>