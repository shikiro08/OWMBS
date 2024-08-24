<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit Client</title>
</head>
<body>
    <div class="container my-5">
        <header class="d-flex justify-content-between my-4">
            <h1>Edit Client</h1>
            <div>
                <a href="client.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <form action="update_client.php" method="post">
            <?php 
            if (isset($_GET['id'])) {
                include("db.php");
                $id = $_GET['id'];
                $sql = "SELECT * FROM client WHERE id=$id";
                $result = mysqli_query($conn, $sql);

                // Check for database connection and query errors
                if (!$result) {
                    die("Error: " . mysqli_error($conn));
                }

                $row = mysqli_fetch_array($result);
            ?>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="cname" placeholder="First Name:" value="<?php echo $row["cname"]; ?>" pattern="[A-Za-z ]+" required>
            </div>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="lname" placeholder="Last Name:" value="<?php echo $row["lname"]; ?>" pattern="[A-Za-z ]+" required>
            </div>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="Mi" placeholder="Middle Name:" value="<?php echo $row["Mi"]; ?>" pattern="[A-Za-z ]+" required>
            </div>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="address" placeholder="Address:" value="<?php echo $row["address"]; ?>" required>
            </div>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="pnumber" placeholder="Phone Number:" value="<?php echo $row["pnumber"]; ?>" pattern="[0-9]+" required>
            </div>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <div class="form-element my-4">
                <input type="submit" name="edit" value="Edit Client" class="btn btn-primary">
            </div>
            <?php
            } else {
                echo "<h3>Client Does Not Exist</h3>";
            }
            ?>
        </form>
    </div>
</body>
</html>