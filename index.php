
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>User - Levels</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
</head>
<body style="background:url(img/rwsa.jpg); background-size:cover;">
    <?php include("header.php"); ?>
    <div class="container">
        <div id="loginbox" style="margin-top:150px; width:450px; 20px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" style="background:url(img/R.jpg); background-size:cover;">
                <div class="panel-heading">
                    <div class="panel-title"><h3>Sign In</h3></div>
                </div>
                <div style="padding: 30px 30px 20px 30px;" class="panel-body">
                    <div style="display:none;" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <?php include("login_form.php"); ?>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
</body>
</html>
