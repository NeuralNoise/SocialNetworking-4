<?php

class Delete
{
    public function DeleteRow($query)
    {
        include("Gateway/config.php");
        $result = mysqli_query($con,$query);
        return $result;
    }
}