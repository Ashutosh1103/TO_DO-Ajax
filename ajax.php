<?php 
include("connection.php");
//for add user 
if(!empty($_POST['item']) && !empty($_POST['desc']) && !empty($_POST['adduser']))
{
   $item=$_POST['item'];
   $desc=$_POST['desc'];

   if(mysqli_query($conn,"insert into to_do(item,description) values('$item','$desc')")){
       echo "User added";
   }
   else {
       echo "User Not Added";
   }
}
//updateuser 
if(!empty($_POST['item']) && !empty($_POST['desc'])  && !empty($_POST['updateuser']) && !empty($_POST['id']))
{
   $item=$_POST['item'];
   $desc=$_POST['desc'];
  
   $id=$_POST['id'];
   if(mysqli_query($conn,"update to_do set item='$item',description='$desc' where id=$id")){
       echo "User Updated";
   }
   else {
       echo "User Not Updated";
   }
}

//for delete user 
if(!empty($_POST['delid']))
{
    $id=$_POST['delid'];
    if(mysqli_query($conn,"delete from to_do where id=$id")){
        echo "User Deleted";
    }
    else {
        echo "User Not Deleted";
    }
}

//for edit user 
if(!empty($_POST['editid']))
{
    $id=$_POST['editid'];
    $sel=mysqli_query($conn,"select * from to_do where id=$id");
    $data=mysqli_fetch_assoc($sel);
    if($data){
        echo json_encode($data);
    }
}
?>