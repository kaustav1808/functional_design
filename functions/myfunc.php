<?php
function databaseConnect(){
    $link = mysqli_connect("localhost", "root", "12345","kaustav");

    if($link === false){
       return false;
    }else{
        return $link;
    }
}

function baseurl(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] ;
}

function database_disconnect($link){
    mysqli_close($link);
}


function login_user($link,$use,$password){
    $sql="select id,addby from user where username ="." '".trim($use)."' "." and password = '".md5($password)."';";
    if($result=mysqli_query($link,$sql)){
        $row_num=mysqli_num_rows($result);
        if($row_num==1){
            $row=mysqli_fetch_array($result);
            session_start();
            $_SESSION["id"]=$row["id"];
            $_SESSION["addby"]=$row["addby"];
            return 1;
        }else{
            return 0;
        }
    }else{
        return 2;
    }
}

function register_user($link,$use,$password,$name,$check,$image){

    if ($check == "fresh") {
        $sql = "INSERT INTO user (username,password,name,addby,image) VALUES ('" . trim($use) . "','" . md5(trim($password)) . "', '" . trim($name) . "',0,'".$image."');";
        $result = mysqli_query($link, $sql);
        if ($result != false) {
            return true;
        } else {
            return false;
        }

    }
    else{
        $sql = "INSERT INTO user (username,password,name,addby,image) VALUES ('" . trim($use) . "','" . md5(trim($password)) . "', '" . trim($name) . "',$check,'".$image."');";
        $result = mysqli_query($link, $sql);
        if ($result != false) {
            return true;
        } else {
            return false;
        }
    }
}


function validate_login($user){

    $user=trim($user);
    if(strlen($user)==0){
        return false;
    }else{
        return true;
    }
}



function validate_register($link,$user,$name,$password){

    $user=trim($user);
    $name=trim($name);
    $flag=1;
    if(strlen($user)==0){
        $flag=0;
    }
    if(strlen($name)==0){
        $flag=0;
    }
    if(check_user($link,$user,$password)){
        $flag=0;
    }
    if($flag){
        return true;
    }else{
        return false;
    }
}

function check_user($link,$user,$password)
{
    $sql = "select id from user where username =" . " '" . $user . "' " . " and password = '" . md5($password) . "';";
    if ($result = mysqli_query($link, $sql)){

        $row_num = mysqli_num_rows($result);
        if ($row_num == 1){
           return true;
        }else{
            return false;
        }
    }
}


function get_user($link,$id){
    $sql="SELECT name,username,addby FROM user WHERE id=".$id.";";
    if($result=mysqli_query($link,$sql)){
        $row=mysqli_fetch_array($result);
        return $row;
    }
}

function user_listing($link,$addby){

    $sql = "select name,username,id,image from user where addby = ".$addby.";";
    if ($result = mysqli_query($link, $sql)){
        $row_num = mysqli_num_rows($result);
        if ($row_num >0){
            return $result;
        }else{
           header("Location:welcome.php?msg=You are did not created any user profile");
        }
    }else{
        header("Location:welcome.php?msg=Sorry!we can't connct");
    }
}

function delete_user($link,$id){
$sql="DELETE FROM user WHERE id=".$id.";";
    if ($result = mysqli_query($link, $sql)){
        header("Location:userlisting.php?msg=user is successfully deleted");
    }else{
        header("Location:userlisting.php?msg=Sorry!there is some error");
    }

}


function update_user($link,$username,$name,$id,$image){
    $sql = "UPDATE user SET name='".$name."' ,username='".$username."',image='".$image."' WHERE id=".$id.";";
    if ($result = mysqli_query($link, $sql)){
        header("Location:userlisting.php?msg=user is successfully updated");
    }else{
        header("Location:userlisting.php?msg=Sorry!there is some error");
    }
}

function file_upload($files){

        if(isset($files["photo"]) && $files["photo"]["error"] == 0){

            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $files["photo"]["name"];
            $filetype=  $files["photo"]["type"];
            $filesize = $files["photo"]["size"];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) return false;

            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) return false;

            $actual=image_resizing($_FILES);
            if(!$actual){
                return false;
            }

            if(in_array($filetype, $allowed)){
                   $bool= move_uploaded_file($files["photo"]["tmp_name"], "upload/".$files["photo"]["name"]);
                   if($bool){
                       $oldname="upload/".$files["photo"]["name"];
                       $rename=rename($oldname,"upload/".$actual);

                       if($rename){
                           return $actual;
                       }
                       else
                           return false;
                   }else
                       return false;
            }else{
               return false;
            }
        }else{
            return false;
        }
}



function limit_query($link,$start,$id,$attr,$type){
    $sql = "select name,username,id,image from user  where addby = ".$id." ORDER BY ".$attr. " ".$type." LIMIT ".$start." , 2 ;";
    if($result=mysqli_query($link,$sql)){
        return $result;
    }
}

function search_query($link,$search,$id){
    $sql = "select name,username,id,image from user  where (name LIKE '%".$search."%' or username LIKE '%".$search."%') AND addby=".$id.";";
    if($result=mysqli_query($link,$sql)){
        return $result;
    }

}

function image_resizing($file){
    $filename = explode( "/",$file['photo']['type'] );
    $ext = $filename[1];
    $ext = strtolower( $ext );
    $uploaded_file = $file['photo']['tmp_name'];
    if( $ext == "jpg" || $ext == "jpeg" )
        $source = imagecreatefromjpeg( $uploaded_file );
    else if( $ext == "png" )
        $source = imagecreatefrompng( $uploaded_file );
    else
        $source = imagecreatefromgif( $uploaded_file );

    // getimagesize() function simply get the size of an image
    $arr = getimagesize( $uploaded_file );
    $width=$arr[0];
    $height=$arr[1];

    $ratio = $height / $width;

    // new width 50(this is in pixel format)
    $nw = 200;
    $nh = ceil( $ratio * $nw );
    $dst = imagecreatetruecolor( $nw, $nh );


    imagecopyresampled( $dst, $source, 0, 0, 0,0, $nw, $nh, $width, $height );

    // rename our upload image file name, this to avoid conflict in previous upload images
    // to easily get our uploaded images name we added image size to the suffix
    $rnd_name = 'photos_'.uniqid(mt_rand(10, 15)).'_'.time().$ext;
    // move it to uploads dir with full quality
    if(imagejpeg( $dst, 'upload/thumbs/'.$rnd_name, 100 ))
    {
        return $rnd_name;
    }else{
        return false;
    }
}

function user_image($link,$id){
    $sql = "select image_id,image,image_name,created_time,`like` from user_image  where  user_id=".$id.";";
    if($result=mysqli_query($link,$sql)){
//        echo $sql;
//        exit;
        return $result;
    }else{
        return false;
    }

}

function galary_upload($files,$key){
    if(isset($files["photo"]) && $files["photo"]["error"][$key] == 0){

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $files["photo"]["name"][$key];
        $filetype=  $files["photo"]["type"][$key];
        $filesize = $files["photo"]["size"][$key];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) return false;

        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) return false;

        if(in_array($filetype, $allowed)){
            $actual='user_photos_'.uniqid(mt_rand(10, 15)).'_'.time().'.'.$ext;

            $bool= move_uploaded_file($files["photo"]["tmp_name"][$key], "upload/userimage/".$actual);
            if($bool){
                return $actual;
            }else
                return false;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function galary_photo_upload($link,$id,$image,$description){
    $sql = "INSERT INTO user_image (user_id,image,image_name) VALUES (" . $id . ",'".$image."','".$description."');";
    echo $sql;
    exit;
    $result = mysqli_query($link, $sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function delete_image($link,$id){
    $sql="DELETE FROM user_image WHERE image_id=".$id.";";
    if ($result = mysqli_query($link, $sql)){
        return true;
    }else{
        return false;
    }

}

function edit_image($link,$imagedes,$id){
    $sql = "UPDATE user_image SET image_name='".$imagedes."' WHERE image_id=".$id.";";
   /* echo $sql;
    exit;*/
    if ($result = mysqli_query($link, $sql)){
      return true;
    }else{
        return false;
    }
}
?>