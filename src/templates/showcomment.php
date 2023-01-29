<?php
//var_dump($comment);
if(isset($comment)){?>
<div class="card m-2">
    <div class="card-header">
        <p class="card-text"><?php echo $comment->getUsername()?></p>
        <p class="card-text"><?php echo $comment->getDate()?></p>
    </div>
    <div class="card card-body">
        <p class="card-text"><?php echo $comment->getBody()?></p>
    </div>
</div>
<?php }?>