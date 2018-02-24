<?php
    $flag =4;
    if(isset($_POST["username"])&& isset($_POST["name"])&& isset($_POST["password"])){
    include_once "functions/myfunc.php";
    $db=databaseConnect();

    if($db==false){
        $flag=0;
    }
    $var=validate_register($db,$_POST["username"],$_POST["name"],$_POST["password"]);

    if(validate_register($db,$_POST["username"],$_POST["name"],$_POST["password"])){
        $photo_upload=file_upload($_FILES);
        if($photo_upload){
            $userregistration=register_user($db,$_POST["username"],$_POST["password"],$_POST["name"],$_POST["adduse"],$photo_upload);
            if($userregistration==true){
                $flag=1;
            }else{
                $flag=0;
            }
        }
        else{
            $flag=0;
        }
    }else{
        $flag=2;
    }
        database_disconnect($db);
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

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <fieldset>

        <legend>Register</legend>

        <?php if($flag==0){?>
            <div class="form-group">
                <div class="col-md-4">
                    <div class="alert alert-warning">
                        <strong>oops! </strong> there is some connection problem.
                    </div>
                </div>
            </div>
        <?php }
        else if($flag==2){
        ?>
            <div class="form-group">
                <div class="col-md-4">
                    <div class="alert alert-danger">
                        <strong>Please!</strong> provide valid username and password
                    </div>
                </div>
            </div>
        <?php }
        else if($flag==1){
        ?>
            <div class="form-group">
                <div class="col-md-4">
                    <div class="alert alert-success">
                        <strong>Yeppy!</strong> you are in
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="form-group">
            <label class="col-md-4 control-label" for="Name">Name</label>
            <div class="col-md-2">
                <input id="Name" name="name" type="text" placeholder="Name" class="form-control input-md" >

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="username">User Name</label>
            <div class="col-md-2">
                <input id="username" name="username" type="text" placeholder="User Name" class="form-control input-md" >

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-2">
                <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required>

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="fileSelect"></label>
            <div class="col-md-4">
                <input type="file" name="photo" id="fileSelect">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-4">
                <input type="hidden" name="adduse" value="fresh";>
                <button type="submit" value="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </fieldset>
</form>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

</html>