<?php
    include('header.php');
    require 'Gateway/SelectClass.php';
    $Select = new Select();
    $result=$Select->SelectRow("select * from post");

?>
<div class="container">
    <?php foreach ($result as $row){ ?>
        <div class="well">
            <h3><?php echo $Select->GatNameFromID($_SESSION['id'])?> </h3>
            <p><?php echo $row['content']?></p>
        </div>
    <?php } ?>
</div>
</div>
</body>
</html>
