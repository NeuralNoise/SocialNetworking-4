<?php
class Insert
{
    public function InsertRow($query)
    {
        include("Gateway/config.php");
        $result = mysqli_query($con, $query);
        return $result;
    }
}