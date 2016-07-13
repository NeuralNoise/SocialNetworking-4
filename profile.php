<?php

    include('header.php');
    require 'Gateway/InsertClass.php';
    require 'Gateway/SelectClass.php';
    require 'Gateway/UpdateClass.php';

    $author_name=$_SESSION['name'];
    $author_id=$_SESSION['id'];
    $Select = new Select();
    $Insert = new Insert();
    if(isset($_POST['postSubmit'])){

        $content=$_POST['post'];

        $Insert->InsertRow("insert into post values ('','$author_id','$content') ");
    }
    $Update = new Update();
    if(isset($_['updateSubmit'])){
        $address=$_POST['address'];
        $Update -> updateRow("Update user_basic_info set user_address ='$address' where user_id='$author_id' ");
    }

    $result = $Select->SelectRow("select * from post where user_id = '$author_id'");
    $pendingList = $Select->SelectRow("select * from user_relation_list where user_id ='$author_id' and status='0'");
    $needtoaccpetlist=$Select->SelectRow("select * from user_relation_list where relative_user_id ='$author_id' and status='0'");
    $_SESSION['result']=$result;

    if(isset($_POST['add'])){
        $id = $_POST['id'];
        $Update = new Update();
        $Update->updateRow("update user_relation_list set status = '1' where id = '$id'");
    }


?>

<div class="col-md-10 col-md-offset-1" xmlns="http://www.w3.org/1999/html">
        <div class="card hovercard">
            <div class="card-background">
                <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/9/">
            </div>
            <div class="useravatar">
                <img alt="" src="images/proimg.jpg">
            </div>
            <div class="card-info"> <span class="card-title"><?php echo $_SESSION['name']; ?></span><br>
            </div>
        </div>
    </div>
    <div class="container col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home">Wall</a></li>
            <li><a href="#menu1">Update Profile</a></li>
            <li><a href="#menu2">Friends</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">

                <div class="form-group">
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="comment">Write Something</label>
                            <textarea class="form-control" rows="4" name="post"></textarea>
                            <button name="postSubmit" type="submit" class="btn btn-info btn-block">Post Now </button>
                        </div>

                    </form>
                </div>

                <div class="row">
                    <?php foreach ($result as $row){ ?>
                    <div class="well">
                        <h3><?php echo $author_name?> </h3>
                        <p><?php echo $row['content']?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="from-control">
                    <div class="container col-md-10 col-md-offset-1  " >

                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <form method="POST" action="" role="form">
                                    <div class="form-group">
                                        <h3>Update Your Information</h3>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address">Address</label>
                                        <input name="address" type="text"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="contacnNumber">Contact Number</label>
                                        <input name="contactnumber" type="text" maxlength="50" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="DOB">Date Of Birth</label>
                                        <input  type="date" name="DOB" type="email" maxlength="50" class="form-control" >
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="school">School</label>
                                        <input name="school"  maxlength="50" class="form-control" value="" length="40">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="HighSchool">High School</label>
                                        <input name="highschool" type="text" maxlength="50" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="about">About You</label>
                                        <input name="about" type="text" maxlength="50" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="about">Upload New Image</label>
                                        <input name="img" type="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button name="updateSubmit" type="submit" class="btn btn-info btn-block">Update</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="menu2" class="tab-pane fade">

                <h3>Relation Request Sent</h3>
                <hr>
                <div class="container">
                    <?php foreach($pendingList as $row1){?>
                        <div class="well col-md-2 col-md-offset-1">
                            <img src="images/proimg.jpg" class="img-rounded" alt="Cinque Terre" width="130" height="130">
                            <p><?php echo $Select->GatNameFromID($row1['relative_user_id']); ?></p>
                            <p><?php echo $Select->GetRelation($row1['relation_type_id'],0)?></p>
                            <p>Request Sent Already</p>
                        </div>
                    <?php }?>
                </div>
                <h3>Request Pending</h3>
                <hr>
                <div class="container">
                    <?php foreach($needtoaccpetlist as $row2){?>
                        <div class="well col-md-2 col-md-offset-1">
                            <img src="images/proimg.jpg" class="img-rounded" alt="Cinque Terre" width="130" height="130">
                            <p><?php echo $Select->GatNameFromID($row2['user_id']); ?></p>
                            <p><?php
                                $rel= $Select->GetRelation($row2['relation_type_id'],1);
                                if($rel=="Child")
                                    echo "Parent";
                                else
                                    echo $rel;
                                ?>
                            </p>
                            <form action="" method="post">
                                <input type="hidden" value = "<?php echo $row2['id'] ?>" name ="id">
                                <button type="submit" name="add" class="btn btn-info">Accept</button>
                            </form>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });
    </script>

</div>

</div>

</body>
</html>

