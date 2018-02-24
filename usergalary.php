<?php
if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location:index.php?msg=you can't access without authentication");
    }
    include_once "functions/myfunc.php";
}

?>
<?php
$db = databaseConnect();
if ($db == false) {
    header("Location:welcome.php?msg=Sorry We Are Unable to Show your User Due To to Some Connection Error");
} else {
    if (isset($_POST["photos"])) {
        for ($i = 0; $i < count($_FILES["photo"]["name"]); $i++) {
            $photo = galary_upload($_FILES, $i);
            if ($photo) {
                $bool = galary_photo_upload($db, $_SESSION["id"], $photo, $_FILES["photo"]["name"][$i]);
            }
        }
        unset($_POST["photos"]);
    }
    else if (isset($_POST["editimage"])){
        $edit_image = edit_image($db,$_POST["image_name"],$_POST["editimage"]);
        if($edit_image){
            $msg="you are  edited a pic";
        }
        else{
            $msg2="Sorry! image description does not edited";
        }
    }
    else if (isset($_GET["type"]) && ($_GET["type"]=="delete")){
         $delete_image = delete_image($db,$_GET["id"]);
         if($delete_image){
             $msg="you are  deleted a pic";
         }
         else{
             $msg2="Sorry! image does not deleted";
         }
    }
    $flag = 1;
    $user_image = user_image($db, $_SESSION["id"]);
    $num = 0;
    if ($user_image) {
        $num = mysqli_num_rows($user_image);
//        echo $num;
//        exit;
    } else {
        $flag = 0;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
            integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/galary.css">
    <script src="js/galary.js"></script>
    <style>
        .alert-dismissable .close, .alert-dismissible .close {
            right: -3px;
        }
        #uploadphoto{
            background-color: #afafaf;
            left: 15px;
            right: 15px;
        }
        #photo{
            padding-top: 10px;
            text-align: left;
            text-decoration: #2679c4;
        }
    </style>

</head>

<body>
<div class="jumbotron">
    <h1 style="text-align: center">
        Here Is Your Galary
    </h1>
</div>
<div class="container">
    <?php if ($flag == 0) { ?>
        <div class="row">
            <div class="alert alert-warning alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>OOps!</strong> Seems you did not have any image.
            </div>
        </div>
    <?php } ?>
</div>

<!--<div class="container">-->
<!--    --><?php //for ($i = 1; $i <= $num; $i++) {
//        $row = mysqli_fetch_array($user_image);
//
//        if ($i % 5 == 0) {
//            ?>
<!--            <div class='row'>-->
<!--            <div class='col-sm-3'>-->
<!--                <img class='img-thumbnail' src='upload/userimage/-->
<?php //echo $row["image"]; ?><!--' alt="" width="250" height="100">-->
<!--            </div>-->
<!--        --><?php //} else {
//            ?>
<!--            <div class='col-sm-3'>-->
<!--                <img class='img-thumbnail' src='upload/userimage/-->
<?php //echo $row["image"]; ?><!--' alt="" width="250" height="100">-->
<!--            </div>-->
<!--            --><?php //if (($i % 5) == 4) { ?><!-- </div> --><?php //} ?>
<!--        --><?php //}
//    } ?>
<!---->
<!--</div>-->
<div class="container">
    <div class="row" >
        <div class="col-md-8" id="uploadphoto">
          <h2 id="photo">Upload Photo</h2>
        </div>
        <div class="col-md-4">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" class="form-control" placeholder="Upload photo" name="photo[]" multiple="">
                    <button class="btn btn-default btn-md" type="submit" name="photos" value="photo"><i class="glyphicon glyphicon-upload"></i></button>

                </div>
            </form>
        </div>
    </div>
</div>
<br>
<div class="container">
    <?php if(isset($msg)){?>
        <div class="alert alert-success alert-dismissable" >
            <p><?php echo $msg ; ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">close</a>
            </p>
        </div>
    <?php unset($msg);}
    else if(isset($msg2)){?>
        <div class="alert alert-danger alert-dismissable">
            <p><?php echo $msg2 ; ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">close</a>
            </p>
        </div>
    <?php unset($msg2);} ?>
    <div class="row">
        <?php while ($row = mysqli_fetch_array($user_image)) { ?>
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <!--                    <img src="upload/userimage/--><?php //echo $row["image"];?><!--" alt="">-->
                    <a href="<?php echo baseurl(); ?>/firstwork/upload/userimage/<?php echo $row["image"]; ?>"
                       data-lightbox="gallery-1"
                       id="<?php echo $row['image_id'];?>">
                    <img src="<?php echo baseurl(); ?>/firstwork/upload/userimage/<?php echo $row["image"]; ?>" alt="">
                    </a>

                    <div class="caption">
                        <h4><?php echo $row["image_name"] ?></h4>
                        <p><?php echo $row["created_time"] ?></p>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-success" role="button" data-toggle="modal" href="#modal<?php echo $row["image_id"]; ?>">Edit</a>
                                <!-- Modal -->
                                <div class="modal fade" id="modal<?php echo $row["image_id"]; ?>" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p style="text-align: center">Edit your image description</p>
                                            </div>
                                            <div style="padding-left: 20px;">
                                                <form action="" method="post">
                                                    <input type="text" name="image_name" value="<?php echo $row["image_name"]; ?>">
                                                    <button class="btn btn-primary" type="submit" name="editimage" value="<?php echo $row["image_id"]; ?>">Edit</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div clas="col-md-4">

                            </div>
                            <div clas="col-md-4">
                                <a href="usergalary.php?id=<?php echo $row["image_id"];?>&type=delete" class="btn btn-danger" role="button">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


</body>
<script>
    $("#lightbox").on("click", "a.add", function() {
        console.log('check');
        var new_caption = prompt("Enter a new caption");
        if (new_caption) {
            var parent_id = $(this).data("id"),
                img_title = $(parent_id).data("title"),
                new_caption_tag = "<span class='caption'>" + new_caption + "</span>";

            $(parent_id).attr("data-title", img_title.replace(/<span class='caption'>.*<\/span>/, new_caption_tag));
            $(this).next().next().text(new_caption);
        }
    });
    // Make an AJAX request to save the data to the database

</script>
</html>