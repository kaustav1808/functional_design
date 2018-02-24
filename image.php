<?php
session_start();
$id = $_SESSION['id'];

include("functions/myfunc.php");
$db = databaseConnect();

if(isset($_GET['like'])){
    $response['status'] = 0;
    $response['data'] = '';
      $like = $_GET['like'];

    $query = mysqli_query($db, "SELECT * FROM like_image WHERE user_id={$id} AND image_id = {$like}") or die(mysqli_error($db));

            if(mysqli_num_rows($query) > 0){
                $response['status'] = 1;
                echo json_encode($response);
             }
             else{
            $insert_i = "INSERT INTO `like_image` (`user_id`, `image_id`) VALUES ($id,$like)";
            $run2 = mysqli_query($db,$insert_i) or die(mysqli_error($db));

            if($run2){
                $hitno ="UPDATE user_image SET `like`=`like`+1 where image_id=".$like.";";
                $run_i = mysqli_query($db, $hitno) or die(mysqli_error($db));
                $response['status'] = 3;
                $sql="SELECT `like` FROM user_image WHERE image_id=".$like.";";
                $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                $r = mysqli_fetch_row($result);
                $response['data'] = $r[0];
                echo json_encode($response);
            }else{
                $response['status'] = 2;
                echo json_encode($response);
            }
        }

}
