<?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasien_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienadmisi_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienmasukpenunjang_id',array('readonly' => true)); ?>

<div class="col-sm-12 one-dropdown">
    <div class="control-group">
        <label class="control-label">
            Kemampuan Fungsional
        </label>
    </div>
    
    <?php
        $i = 1;
        foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_FUNGSIONAL]['type'] as $det){
    ?>
        <div class="control-group">
            <label class="control-label">
                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$form->checkBox($model,'[det_fungsional][]kemampuan_fungsional',array('checked'=>($model->kemampuan_fungsional == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." ".$det['value']; ?>
            </label>
            <div class="controls">
                <label><?php echo $det['name']; ?></label>
            </div>
        </div>
    <?php
        }
    ?>
</div>
