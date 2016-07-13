<?php


    include('header.php');
    require 'Gateway/SelectClass.php';
    require 'Gateway/CheckClass.php';
    require 'Gateway/InsertClass.php';
   // var_dump($_SESSION);
    $select = new Select();
    $Check = new Check();
    $insert =  new Insert();
    $author_id= $_SESSION['id'];
    $author_gender=$_SESSION['gender'];
    $relations = $select->SelectRow("select * from relation_type");
    $result=array();
    if(isset($_GET['search'])){
        $keyword = $_GET['keyword'];
        $result=$select->SelectRow("select * from user_info WHERE user_name like '%$keyword%'");

    }

    if(isset($_POST['addfriend'])){
        $friendid=$_POST['friendid'];
        $relationtype= $_POST['Select'];

        $insert->InsertRow("insert into user_relation_list values ('','$author_id','$friendid','$relationtype','0') ");

    }


?>
<div class="container">
    <div class="row">
        <h2>Type Your Relative name</h2>
        <div id="custom-search-input">

                <form method="get" class="form-inline" action="">
                <div class="row">
                    <input type="text"  class="search-query form-control" style="width: 80%" name="keyword" placeholder="Search" />
                    <button type="submit" name="search" class="btn btn-danger fa fa-search " style="height: 30px;" >Search </button>
                </div>
                </form>

        </div>
    </div>
</div>

<div class="container">
    <?php foreach($result as $row){?>
        <?php if($author_id == $row['id']) continue; ?>
        <div class="well col-md-2 col-md-offset-1">
            <img src="images/proimg.jpg" class="img-rounded" alt="Cinque Terre" width="130" height="130">
            <p><?php echo $row['user_name'];?></p>

            <?php if($Check->FriendCheck($author_id,$row['id'])=="no" ){ ?>
                <form class="form-group" action="" method="post" >
                    <select class="form-control" name="Select">
                    <?php foreach($relations as $row2) { ?>
                        <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                    <?php }?>
                    </select>
                    <input type="hidden" name="friendid" value="<?php echo $row["id"]; ?>">
                    <button type="submit" name="addfriend"class="btn btn-primary" >ADD</button>
                </form>
            <?php } else  { ?>
                <p>Already added in your relation </p>
            <?php }?>

        </div>
    <?php } ?>
</div>
    
</div>
</body>
</html>

