<div class="control-group">
    <label class="control-label"><b>Cairan Keluar</b></label>
    <div class="controls">
        
    </div>
</div>

<div class="control-group">
    <label class="control-label">Jam Ke -</label>
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'jam_ke', array('placeholder' => 'ketikkan angka untuk nilai Jam Ke -','class' => 'numbers-only span1')); ?>
    </div>
</div>
<?php
    $output = LookupM::getItemsUrutan('monitorintraanestesi_outcairankeluar');
    
    if (!empty($output)){
        $i = 0;
        foreach($output as $key => $val){
            $model->jenis_output2 = $key;
?>
        <div class="control-group">
            <label class="control-label"><?php echo $val ?></label>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model, '[det]['.$i.']nama_output2',array('class' => 'span4'));
                    echo CHtml::activeHiddenField($model, '[det]['.$i.']jenis_output2',array('class' => 'span4', 'readonly' => true)) ;
                ?>
            </div>
            <div class="controls">
                <?php
                    if ($key == Params::MONITOR_INTRAANESTESI_OUTCAIRANKELUAR_EBL){
                        echo '<label>%</label>';
                    }
                ?>
            </div>
        </div>
<?php
        $i++;
        }
    }
        
?>

