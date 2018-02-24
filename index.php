<?php
$flag = 1;
if(isset($_POST["Login"])&& isset($_POST["passwordinput"])){
    include_once "functions/myfunc.php";
    $validate=validate_login($_POST["Login"]);
    if($validate==true){
        $db=databaseConnect();
        if($db==false){
            $flag=2;
        }
        $userlogin=login_user($db,$_POST["Login"],$_POST["passwordinput"]);
        if($userlogin==1){
            header("Location:welcome.php");
        }
        else if($userlogin==0){
            $flag=0;
        }else{
            $flag=2;
        }
        database_disconnect($db);
    }else{
       $flag=3;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>
        That's first html css design
    </title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="first.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <form class="form-horizontal" method="post" action="">
        <fieldset>
            <legend>Welcome to Login</legend>
            <div class="form-group">
                <label class="col-md-4 control-label" for="Login">Login</label>
                <div class="col-md-4">
                    <input id="Login" name="Login" type="text" placeholder="" class="form-control input-md">
                    <span class="help-block">Enter login</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="passwordinput">Password</label>
                <div class="col-md-4">
                    <input id="passwordinput" name="passwordinput" type="password" placeholder="" class="form-control input-md">
                    <span class="help-block">Enter password</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="buttonLogin"></label>
                <div class="col-md-8">
                    <button type="submit" id="buttonLogin" name="buttonLogin" class="btn btn-success" value="SUBMIT">Login</button>
                    <a id="buttonRegistry" name="buttonRegistry" class="btn btn-primary" href="register.php">Registry</a>
                </div>
            </div>

        </fieldset>
    </form>
</div>
<?php if($flag === 2){?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="alert alert-warning alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>oops! </strong> there is some connection problem.
                </div>
            </div>
        </div>
    </div>
<?php }
else if($flag === 0){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Sorry!</strong> username or password does not match
                </div>
            </div>
        </div>
    </div>
<?php }
else if($flag==3){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Please!</strong> provide the correct user name and password
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if(isset($_GET["msg"])){?>
    <div class="container">
        <div class="col-lg-6">
            <div class="alert alert-warning">
                <?php   echo $_GET["msg"];?>
            </div>
        </div>
    </div>
<?php } ?>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

</html>