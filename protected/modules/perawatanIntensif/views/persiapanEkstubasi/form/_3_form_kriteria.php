<?php
    $kriteria = LookupM::getItemsUrutan('ekstubasi');
?>
<div class="panel panel-success">    
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="controls">Kriteria Pasien untuk dapat diekstubasi:</label>
            </div>
        </div>
        
        <div class="clear"></div>
        
        <?php
            $total = floor(count($kriteria)/2);
            
            $i = 0;
            foreach($kriteria as $key => $val){
                
                if ($i == 0){
                    echo '<div class="col-sm-6">';
                }
                
                if ($i % $total == 0 && $i != 0){
                    echo '</div>';
                    echo '<div class="col-sm-6">';
                }
        ?>
                <div class="control-group">
                    <div class="controls" style="margin-left: 20px;">&nbsp;</div>
                    <?= $form->checkBox($model, $key,['id'=>$key]) ?> <label for="<?= $key ?>"><?= $val ?></label>
                </div>
        <?php
                if ($i == count($kriteria)){
                    echo '</div>';
                }
        
                $i++;
            }
        ?>
        <div class="col-sm-6">
            
            
        </div>
        
        
    </div>
</div>