<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Display error message if it exists in the URL parameters -->
<?php if (isset($_GET['error'])) { ?>
    <p class="error" style="color: red;"><?php echo $_GET['error']; ?></p>
<?php } ?>

<form action="login.php" method="post">
    <div style="margin-bottom: 25px" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input id="login-username" type="text" class="form-control" name="uname" placeholder="Username">
    </div>
    <div style="margin-bottom: 25px" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="login-password" type="password" class="form-control" name="pword" placeholder="Password">
    </div>
    <div style="margin-top:10px" class="form-group">
        <!-- Button -->
        <div class="col-sm-12 controls">
            <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-check"></span> Login</button>
        </div>
    </div>
</form>
