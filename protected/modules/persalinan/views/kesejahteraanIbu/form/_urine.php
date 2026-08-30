<div class="form_pilih">
<?php 

if (!$model->isNewRecord) {
    $mod = KesejahteraanibuurineT::model()->findByAttributes(array(
        'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
    ));
    if (empty($mod)) {
        $mod = new KesejahteraanibuurineT;
    } else {
        $mod->urine_volume = number_format($mod->urine_volume, 2, ",", "");
    }
} else {
    $mod = new KesejahteraanibuurineT;
}

echo '<strong>'.CHtml::checkBox('is_urine', !$mod->isNewRecord, array('class'=>'form_pilih_ceklis'))." ".CHtml::label('Urine', '', array('style'=>'font-weight: bold;', 'uncheckValue'=>null)).'</strong>';
?>
    <div class="form_pilih_content">
        <div class="control-group">
            <?php echo $form->label($mod, 'urine_protein', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'urine_protein', array('class'=>'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($mod, 'urine_aseton', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'urine_aseton', array('class'=>'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($mod, 'urine_volume', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'urine_volume', array('class'=>'span2 float2')); ?>
            </div>
        </div>
    </div>
</div>