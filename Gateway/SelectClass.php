<?php

class Select
{
    public function SelectRow($query)
    {
        include("Gateway/config.php");
        $result = mysqli_query($con,$query);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function GetLastID ($tablename)
    {
        include("Gateway/config.php");

        $query = "select * from ".$tablename." ";
        $result = mysqli_query($con,$query);
        $rows = array();
        $id=0;
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        foreach($rows as $row)
        {
            $id=$row['id'];
        }
        return $id;
    }
    public function GatNameFromID ($id)
    {
        include("Gateway/config.php");

        $query = "select * from user_info WHERE id = '$id'";
        $result = mysqli_query($con,$query);
        $rows = array();
        $name="Unknown";
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        foreach($rows as $row)
        {
            $name=$row['user_name'];
        }
        return $name;
    }

    public function GetRelation ($id )
    {
        include("Gateway/config.php");
        $query="select * from relation_type where id = '$id'";
        $result = mysqli_query($con,$query);
        $rows = array();
        $r1="";

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        foreach($rows as $row)
        {
            $r1 = $row['name'];
        }

        return $r1;

    }

}