<?php
include_once('db.php');
$query = "SELECT * from relay_events order by id desc";
$tquery = "SELECT * from sensor_data order by id desc";
$uquery = "SELECT * from waterlevel order by id desc";
$tresult = mysqli_query($conn, $tquery);
$result = mysqli_query($conn, $query);
$uquery = mysqli_query($conn, $uquery);

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");
?>

<?php
include 'header.php';
include 'sidebaruser.php';
?>

<div class="container-fluid px-4">
    <!-- Top Section -->
    <div class="row my-5">
        <div class="col">
            <h3 class="fs-4 mb-3">Valve Status</h3>
            <table class="table bg-white rounded shadow-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="50">#</th>
                        <th scope="col">time</th>
                        <th scope="col">Valve_id</th>
                    </tr>
                </thead>
                <?php
                $counter = 0;
                while (($rows = mysqli_fetch_assoc($result)) && $counter < 5) {
                ?>
                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $rows['id']; ?></th>
                            <td><?php echo $rows['time']; ?></td>
                            <td><?php echo $rows['valve_id']; ?></td>
                        </tr>
                    </tbody>
                <?php
                    $counter++;
                }
                ?>

            </table>
        </div>
    </div>

    <!-- Bottom Section -->
<div class="row my-5">
    <div class="col">
        <h3 class="fs-4 mb-3">PH Level</h3>
        <table class="table bg-white rounded shadow-sm table-hover">
            <thead>
                <tr>
                    <th scope="col" width="50">#</th>
                    <th scope="col" width="50">Sensor1_id</th>
                    <th scope="col" width="50">Sensor2_id</th>
                    <th scope="col" width="50">time</th>
                </tr>
            </thead>
            <?php 
            $counter = 0;
            while(($trows = mysqli_fetch_assoc($tresult)) && $counter < 5){ ?>
                <tbody>
                    <tr>
                        <th scope="row"><?php echo $trows['id']; ?></th>
                        <td><?php echo $trows['sensor1_value']; ?></td>
                        <td><?php echo $trows['sensor2_value']; ?></td>
                        <td><?php echo $trows['Timestamp']; ?></td>
                    </tr>
                </tbody>
            <?php
                $counter++;
            } 
            ?>
        </table>
    </div>
</div> <!-- Close the Bottom Section div here -->

<!-- Third Section -->
<div class="row my-5">
    <div class="col">
        <h3 class="fs-4 mb-3">Water Level</h3>
        <table class="table bg-white rounded shadow-sm table-hover">
            <thead>
                <tr>
                    <th scope="col" width="50">#</th>
                    <th scope="col" width="50">Water Level</th>
                    <th scope="col" width="50">time</th>
                </tr>
            </thead>
            <?php 
            $counter = 0;
            while(($urows = mysqli_fetch_assoc($uquery)) && $counter < 5){ ?>
                <tbody>
                    <tr>
                        <th scope="row"><?php echo $urows['id']; ?></th>
                        <td><?php echo $urows['water_Level']; ?></td>
                        <td><?php echo $urows['time']; ?></td>
                    </tr>
                </tbody>
            <?php
                $counter++;
            } 
            ?>
        </table>
    </div>
</div> <!-- Close the Third Section div here -->

    

</div>

<?php
include 'footer.php';
?>
