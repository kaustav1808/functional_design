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
}else{
    if(isset($_POST["delete"])){
      delete_user($db,$_POST["delete"]);
    }else if(isset($_GET["page"])&&(!isset($_POST["search"]))){
        $limit=2;
        $result=user_listing($db,$_SESSION["id"]);
        $numresult=mysqli_num_rows($result);
        $pages=ceil($numresult/$limit);
        $curpage=isset($_GET["page"])?$_GET["page"]:0;
        $start=($curpage*$limit);
        $order=(isset($_GET["type"])&&($_GET["type"]=="ASC"))?"DESC":"ASC";
        $attr=isset($_GET["attr"])?$_GET["attr"]:"id";
        $limit_query=limit_query($db,$start,$_SESSION["id"],$attr,$order);
    }else if(isset($_POST["search"])){
           $search_result=search_query($db,$_POST["search"],$_SESSION["id"]);
           $limit_query=$search_result;
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
    <link rel="stylesheet" href="css/userlisting.css">
    <style>
        a{
           color: #000000;
           text-decoration: none;
        }
        a:hover{
            color: #555555;
            text-decoration: none;
        }
     </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="span7">
                <div class="widget stacked widget-table action-table">
                    <div class="widget-header">
                        <i class="icon-th-list"></i>
                        <h3>Myuser</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="pagination pagination-lg">
                                <?php for($i=0;$i<$pages;$i++){?>
                                    <li><a href="userlisting.php?page=<?php echo $i;?>"><?php echo ($i+1);?></a></li>
                                <?php }?>
                            </ul>
                        </div>

                        <div class="col-md-4">
                        </div>

                        <div class="col-md-4 " style="margin-top: 40px;padding-right: 40px; padding-left: 60px;">
                            <form method="post" action="">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Search" name="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                        <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th><a href="userlisting.php?page=<?php echo $curpage ;?>&attr=name&type=<?php echo $order;?>" title="Sort Name">Name</a></th>
                                        <th><a href="userlisting.php?page=<?php echo $curpage ;?>&attr=username&type=<?php echo $order;?>" title="Sort UserName">User Name</a></th>
                                        <th>User Image</th>
                                        <th class="td-actions"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                          while($row=mysqli_fetch_array($limit_query)){?>
                                              <tr>
                                        <td><?php echo $row["name"];?></td>
                                        <td><?php echo $row["username"];?></td>
                                              <td> <image src="upload/thumbs/<?php echo $row["image"];?>" class="img-rounded" width="150" height="100"></image></td>
                                        <td class="td-actions">
                                            <form action="" method="post">
                                                <a href="userupdate.php?id=<?php echo $row["id"];?>" class="btn btn-lg btn-primary">
                                                    <i class="btn-icon-only icon-ok"></i>edit
                                                </a>
                                                <button type="submit" name="delete" value="<?php echo $row["id"];?>"  class="btn btn-lg btn-danger">
                                                    <i class="btn-icon-only icon-ok"></i>delete
                                                </button>
                                            </form>
                                        </td>
                                              </tr><?php } ?>
                                    </tbody>
                        </table>
                    </div>
                </div>
           </div>
      </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-6">

        </div>
        <div class="col-md-2">
            <form action="userupdate.php" method="post">
                <button type="submit" class="btn btn-primary btn-lg btn-block" name="adduser" value="new">Add User</button>
            </form>
        </div>
    </div>
</div>
<?php if(isset($_GET["msg"])){?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="alert alert-warning">
                    <?php   echo $_GET["msg"];?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

</html>