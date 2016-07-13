<?php


class Findrelatives
{

    public function partner($id)
    {
        require "SelectClass.php";
        include("Gateway/config.php");
        $Select = new Select();
        $result= $Select->SelectRow("select * from user_relation_list where user_id = '$id' and relation_type_id='1' ");
        $r1=0;
        foreach($result as $row)
        {
            $_SESSION['abc']=$row['relative_user_id'];
            $r1 = $row['relative_user_id'];
        }
        if($r1==0)
        {
            $result= $Select->SelectRow("select * from user_relation_list where relative_user_id = '$id' and relation_type_id='1' ");
            foreach($result as $row)
            {

                $r1 = $row['user_id'];
            }
        }
        return $Select->GatNameFromID($r1);
    }
    public function Childs($id)
    {
        require "SelectClass.php";
        include("Gateway/config.php");
        $Select = new Select();
        $result= $Select->SelectRow("select * from user_relation_list where user_id = '$id' and relative_user_id='2' ");
        $r1=0;
        $res=array();
        foreach($result as $row)
        {
            $res[$r1] = $row['relative_user_id'];
            $r1++;

            if($r1==2)
                break;
        }
        if($r1==0)
        {
            $res[0]=0;
            $res[1]=0;
        }
        if($r1==1)
        {
            $res[1]=0;
        }
        return $res;
    }
}




