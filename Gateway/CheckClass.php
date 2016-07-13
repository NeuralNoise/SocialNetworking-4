<?php

    class Check
    {
        public function FriendCheck($id1, $id2){
        include("Gateway/config.php");
        $query="select * from user_relation_list WHERE user_id='$id1'and relative_user_id='$id2'";
        $query2="select * from user_relation_list WHERE user_id='$id2'and relative_user_id='$id1'";
        $_SESSION['q']=$query;
        $result= mysqli_query($con,$query);
        $result2=mysqli_query($con,$query2);
        if(mysqli_num_rows($result)==1 )
            return "yes";
        elseif(mysqli_num_rows($result2)==1)
            return "yes";
        else
            return "no";
    }
}
?>