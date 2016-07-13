<?php


    require 'Gateway/InsertClass.php';
    require 'Gateway/SelectClass.php';
    session_start();

    if(isset($_POST['signupSubmit'])){

        $user_name=$_POST['signupname'] ;
        $user_email=$_POST['signupemail'] ;
        $gender=$_POST['signupgender'];
        $password=$_POST['signuppassword'];

        $Insert = new Insert();
        $query="Insert into user_info values ('','$user_name' , '$user_email' , '$gender' , '$password')";
        $result= $Insert->InsertRow($query);
        $Select = new Select();
        $id=$Select->GetLastID("user_info");
        $query="Insert into user_basic_info (user_id) values ('$id')";
        $result2= $Insert->InsertRow($query);

        if($result>0 && $result2>0) {
            $_SESSION['signupstatus']="done";
        }
        else{
            $_SESSION['signupstatus']="tryagain";
        }
    }

    if(isset($_POST['loginsubmit'])){
        $user_email=$_POST['loginemail'] ;
        $password=$_POST['loginpassword'];

        $query= "select * from user_info where user_email='$user_email' and password = '$password'";
        $Select = new Select();
        $result=$Select->SelectRow($query);


        if(count($result)==1){
            foreach($result as $item) {
                $_SESSION['name'] = $item['user_name'];
                $_SESSION['id'] = $item['id'];
                $_SESSION['gender'] = $item['gender'];
            }
            header('Location: home.php');
        }



    }


?>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/mainlogin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

    <body>

        <nav class="navbar navbar-default navbar-inverse" role="navigation">
            <div class="container-fluid">




                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        <li><p class="navbar-text">Already have an account?</p></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                            <ul id="login-dp" class="dropdown-menu">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form class="form" role="form" method="post" action="" accept-charset="UTF-8" id="login-nav">
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                    <input type="email" class="form-control" name="loginemail" placeholder="Email address" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                    <input type="password" class="form-control" name="loginpassword" placeholder="Password" required>
                                                    <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name = "loginsubmit" class="btn btn-primary btn-block">Sign in</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="sign-up">
            <div class="container col-md-4 col-md-offset-1  " >

                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <form method="POST" action="#" role="form">
                                <div class="form-group">
                                    <h2>Create account</h2>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="signupName">Your name</label>
                                    <input name="signupname" type="text" maxlength="50" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="signupEmail">Email</label>
                                    <input name="signupemail" type="email" maxlength="50" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="signupEmailagain">Email again</label>
                                    <input name="signupEmailagain" type="email" maxlength="50" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="Gender">Gender</label>
                                    <input type="radio" value="male" name="signupgender"> Male
                                    <input type="radio" value="female" name="signupgender"> Female
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="signupPassword">Password</label>
                                    <input name="signuppassword" type="password" maxlength="25" class="form-control" placeholder="at least 6 characters" length="40">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="signupPasswordagain">Password again</label>
                                    <input name="signuppasswordagain" type="password" maxlength="25" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button name="signupSubmit" type="submit" class="btn btn-info btn-block">Create your account</button>
                                </div>

                            </form>
                        </div>
                    </div>

            </div>
        </div>


    </body>
</html>