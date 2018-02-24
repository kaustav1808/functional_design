<?php
if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location:index.php?msg=you can't access without authentication");
    }
    include_once "functions/myfunc.php";
}
if (isset($_POST["buttonLogout"])) {
    session_unset();
    session_destroy();
    header("Location:index.php");
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

    <link rel="stylesheet" href="css/mycss.css">
<!--    <script href="js/galary.js"></script>-->
</head>

<body>

<?php
$db = databaseConnect();
if ($db == false) {
    $flag = 0;
} else {
    $flag = 1;
    $row = get_user($db, $_SESSION["id"]);
}
?>

<div class="profile-block">
    <div class="panel text-center">
        <?php if ($flag == 0) { ?>
            <div class="user-heading"><a href="#"><img
                            src="http://cumbrianrun.co.uk/wp-content/uploads/2014/02/default-placeholder-300x300.png"
                            alt="" title=""></a>
                <h1>WELCOME</h1>
                <p>USER</p>
                <p>GOOD DAY</p>
            </div>
        <?php } else { ?>
            <div class="user-heading"><a href="#"><img src="upload/image.png" alt="" title=""></a>
                <h1>WELCOME</h1>
                <p><?php echo $row["username"]; ?></p>
                <p><?php echo $row["name"]; ?></p>
            </div>
        <?php } ?>
        <ul class="nav nav-pills nav-stacked">
            <li><a id="buttonRegistry" href="userlisting.php?type=new">Add User</a></li>
            <li><a id="buttonRegistry" href="userlisting.php?page=0">My User</a></li>
            <li><a id="buttonRegistry" href="usergalary.php?">My Gallery</a></li>
            <form action="" method="post">
                <li>
                    <button type="submit" id="buttonlogout" name="buttonLogout" value="logout"><i
                                class="fa fa-sign-out"></i>Logout
                    </button>
                </li>
            </form>
        </ul>
    </div>
</div>

<div class="container">
    <?php
    $image = user_image($db, $row["addby"]);
    if ($image) {
        ?>
        <?php while ($row2 = mysqli_fetch_array($image)) { ?>
            <div class="col-xs-18 col-sm-6 col-md-3">
                <div class="thumbnail">
                    <a href="<?php echo baseurl(); ?>/firstwork/upload/userimage/<?php echo $row2["image"]; ?>"
                       data-lightbox="gallery-1"
                       id="<?php echo $row2['image_id']; ?>">
                        <img src="<?php echo baseurl(); ?>/firstwork/upload/userimage/<?php echo $row2["image"]; ?>"
                             alt="">
                    </a>
                    <div class="caption">
                        <h4><?php echo $row2["image_name"] ?></h4>
                        <br>
                        <a class="image-like-btn" href="image.php?like=<?php echo $row2["image_id"]; ?>">
                            <i class="glyphicon glyphicon-thumbs-up"></i>
                            <p><?php echo $row2["like"]; ?></p>
                        </a>

                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<script type = "text/javascript"
        src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"-->
<!--        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"-->
<!--        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"-->
<!--        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"-->
<!--        crossorigin="anonymous"></script>-->


<script>
    $(document).ready(function () {
        $(".image-like-btn").click(function (e) {
            e.preventDefault();
            var URL = $(this).attr('href');
            var that = $(this);
            $.ajax({
                url: URL,
                type: 'GET',
                error: function () {
                    alert("internal error");
                },
                success: function (data) {
                    console.log(data);
                    var json_object = $.parseJSON(data);// JSON.parse();
                    if (json_object.status == 1) {
                        alert("You have already liked !!");
                    }
                    if (json_object.status == 2) {
                        alert("Oops !! somthing went wrong");
                    }
                    if (json_object.status == 3) {
                         that.find('p').text(json_object.data);
                    }
                }
            });
        });
    });
</script>

<!--<script>-->
<!--    $("#lightbox").on("click", "a.add", function () {-->
<!--        console.log('check');-->
<!--        var new_caption = prompt("Enter a new caption");-->
<!--        if (new_caption) {-->
<!--            var parent_id = $(this).data("id"),-->
<!--                img_title = $(parent_id).data("title"),-->
<!--                new_caption_tag = "<span class='caption'>" + new_caption + "</span>";-->
<!---->
<!--            $(parent_id).attr("data-title", img_title.replace(/<span class='caption'>.*<\/span>/, new_caption_tag));-->
<!--            $(this).next().next().text(new_caption);-->
<!--        }-->
<!--    });-->
<!---->
<!--</script>-->
</body>



</html>