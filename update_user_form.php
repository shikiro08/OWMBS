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
            <h1>Edit User</h1>
            <div>
                <a href="users.php" class="btn btn-primary">Back</a>
            </div>
        </header>
        <form action="update_user.php" method="post">
            <?php 
            if (isset($_GET['id'])) {
                include("db.php");
                $id = $_GET['id'];
                $sql = "SELECT * FROM users WHERE id=$id";
                $result = mysqli_query($conn, $sql);

                // Check for database connection and query errors
                if (!$result) {
                    die("Error: " . mysqli_error($conn));
                }

                $row = mysqli_fetch_array($result);
            ?>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="uname" placeholder="User Name:" value="<?php echo $row["uname"]; ?>" pattern=".{5,20}" required>
            </div>
            <div class="form-element my-4">
                <input type="text" class="form-control" name="contact" placeholder="Contact no:" value="<?php echo $row["contact"]; ?>" pattern="[789]\d{9}|0\d{10}" required>
            </div>
            <div class="form-element my-4">
                <input type="email" class="form-control" name="email" placeholder="Email:" value="<?php echo $row["email"]; ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
            </div>
            <div class="form-element my-4">
                <input type="password" class="form-control" name="pword" placeholder="Password:" value="<?php echo $row["pword"]; ?>" required>
            </div>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            <div class="form-element my-4">
                <input type="submit" name="edit" value="Edit User" class="btn btn-primary">
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