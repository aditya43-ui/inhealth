<?php if (isset($step)) { ?>
<div class="dashboard">
<div class="block">
<div><h6>Setting SMS Center Step <?=$step; ?></h6></div>

<?php

$alias = 'application.modules.smsCenter.components.gamPost.step';
for($i=$data['awal']; $i<$data['jumlah'];$i++){
if($step==$i)
    {
        $this->renderPartial($alias.$i,array()); 
    }
}   
?>    
</div>
    </div>
<?php }?>