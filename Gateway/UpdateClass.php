<?php


class Update
{
    public function updateRow($query)
    {
        include("Gateway/config.php");
        $result = mysqli_query($con,$query);
        return $result;
    }
}