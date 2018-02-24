<?php
if(!isset($_SESSION)){
    session_start();
    include_once "functions/myfunc.php";
}
?>
<?php
$db=databaseConnect();
if($db==false){
    header("Location:welcome.php?msg=Sorry We Are Unable to Show your User Due To to Some Connection Error");
}else {
    if (isset($_POST["update"])) {
        $photo = file_upload($_FILES);
        if ($photo) {
            update_user($db, $_POST["username"], $_POST["name"], $_GET["id"],$photo);
        } else {
            update_user($db, $_POST["username"], $_POST["name"], $_GET["id"],"default.jpg");

        }

    } else if (isset($_POST["addusr"])) {

        if (validate_register($db, $_POST["username"], $_POST["name"], $_POST["password"])) {
            $userphoto = file_upload($_FILES);
            if ($userphoto) {
                $register = register_user($db, $_POST["username"], $_POST["password"], $_POST["name"], $_SESSION["id"], $userphoto);
                if ($register == true) {
                    header("Location:userlisting.php?msg=you are successfully created a user");
                } else {
                    header("Location:userlisting.php?msg=Sorry we have some problem");

                }
            } else {

            }

        } else {
            header("Location:userlisting.php?msg=Please provide correct information");

        }

    } else {
        $row = get_user($db, $_GET["id"]);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="userlisting.css">
</head>

<body>
<div class="well">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane active in" id="home">
            <form id="tab" action="" method="post" enctype="multipart/form-data">
            <?php if(!isset($_POST["adduser"])){ ?>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $row["username"];?>" class="input-xlarge">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $row["name"];?>" class="input-xlarge">
                <input type="file" name="photo"  class="input-xlarge">

                <div>
                    <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
                </div>
            <?php }else{ ?>
                <label>Username</label>
                <input type="text" name="username"  class="input-xlarge">
                <label>Name</label>
                <input type="text" name="name"  class="input-xlarge">
                <label>Password</label>
                <input type="password" name="password" value="" class="input-xlarge">
                <input type="file" name="photo"  class="input-xlarge">
                <div>
                    <button type="submit" class="btn btn-primary" name="addusr" value="adduser">Add</button>
                </div>

            <?php
            } ?>
            </form>
        </div>
    </div>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

</html>