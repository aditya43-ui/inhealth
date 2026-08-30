<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $key; ?></div>
    </div>
    <div class="panel-body">
    <?php
        $i = 1;
        ksort($val);
        foreach($val as $k => $v){
            echo $this->renderPartial('_listFile',array('key'=>$k,'val'=>$v, 'tipe'=>$tipe, 'i'=>$i),true);
            $i++;
        }
    ?>
    </div>
</div>