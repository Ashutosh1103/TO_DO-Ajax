<?php 
include("connection.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Index</title>
  </head>
  <body>
   
  <!-- Form -->
  
  <section class="h-100 h-custom" style="background-color: #8fc4b7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-6">
        <div class="card rounded-3">
          <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-registration/img3.jpg" class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem;" alt="Sample photo">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">To Do</h3>

            <div class="px-md-2">

              <div class="form-outline mb-4">
                <input type="text" id="item" name="item" class="form-control" />
                <label class="form-label" for="item">Item</label>
              </div>

              <div class="form-outline mb-4">
                <input type="text" id="desc" name="desc" class="form-control" />
                <label class="form-label" for="desc">Description</label>
              </div>

             

              <input type="hidden" id="uid"/>
              <input type="button" value="Submit" id="adduser" class="btn btn-success"/>
              <input type="button" value="Update" id="updateuser" class="btn btn-success"/>
             

            </div>

            <br>

            <!-- Table -->
    <div id="resultarea">
        <table class="table table-hover table-primary">
        <thead>
            <tr>
                  <th>S.no</th>
                  <th>Item</th>
                  <th>Description</th>
                  
                  <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
          $sel=mysqli_query($conn,"select * from to_do");
          if(mysqli_num_rows($sel)>0){
              $sn=1;
              while($arr=mysqli_fetch_assoc($sel)){
                  ?>
                <tr>
                    <td><?= $sn;?></td>
                    <td><?= $arr['item'];?></td>
                    <td><?= $arr['description'];?></td>
                    
                    <td>
                        <a href="javascript:void(0)" class="btn btn-primary edit" data-id="<?= $arr['id'];?>">Edit</a>
                        <a href="javascript:void(0)" class="btn btn-danger delete" data-id="<?= $arr['id'];?>">Delete</a>
                    </td>
                </tr>
                  <?php 
                  $sn++;
              }
          }
              ?>
        </tbody>
        </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#updateuser").hide();
        //adduser
        $("#adduser").click(function(){
            alert("hello")
            var item=$("#item").val();
            var desc=$("#desc").val();
           
            var formData={item:item,desc:desc,adduser:'adduser'}
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:formData,
                success:function(data){
                    alert(data);
                   // window.location.reload();
                   $("#resultarea").load(document.URL +' #resultarea')
                }
            })
        })

        //updateuser 
        $("#updateuser").click(function(){
           
            var item=$("#item").val();
            var desc=$("#desc").val();
            var id=$("#uid").val();
            var formData={item:item,desc:desc,id:id,updateuser:'updateuser'}
            console.log(formData);
            $.ajax({
                type:"POST",
                url:"ajax.php",
                data:formData,
                success:function(data){
                    alert(data);
                    $("#adduser").show();
                        $("#updateuser").hide();
                        $("#item").val('');
                        $("#desc").val('');
                       
                        $("#uid").val('');
                   // window.location.reload();
                   $("#resultarea").load(document.URL +' #resultarea')
                }
            })
        })

        //deleteuser 
        $(".delete").click(function(){
            if(confirm("Do u want to delete ?")==true){
                var id=$(this).data('id');
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{delid:id},
                    success:function(data){
                        alert(data);
                        $("#resultarea").load(document.URL +' #resultarea')
                    }
                })
            }
        })

        $(".edit").click(function(){
                var id=$(this).data('id');
               
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{editid:id},
                    dataType:'json',
                    success:function(data){
                        console.log(data.description)
                        $("#item").val(data.item);
                        $("#desc").val(data.description);
                       
                        $("#uid").val(data.id);
                        $("#adduser").hide();
                        $("#updateuser").show();
                    }
                })
           
        })
    })
</script>
  </body>
</html>