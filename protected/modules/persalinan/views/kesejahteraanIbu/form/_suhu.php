<div class="form_pilih">
<?php 

if (!$model->isNewRecord) {
    $mod = KesejahteraanibusuhuT::model()->findByAttributes(array(
        'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
    ));
    if (empty($mod)) {
        $mod = new KesejahteraanibusuhuT;
    } else {
        $mod->suhutubuh = number_format($mod->suhutubuh, 2, ",", "");
    }
} else {
    $mod = new KesejahteraanibusuhuT;
}

echo '<strong>'.CHtml::checkBox('is_suhu', !$mod->isNewRecord, array('class'=>'form_pilih_ceklis'))." ".CHtml::label('Suhu Tubuh', '', array('style'=>'font-weight: bold;', 'uncheckValue'=>null)).'</strong>';
?>
    <div class="form_pilih_content">
        <div class="control-group">
            <?php echo $form->label($mod, 'suhutubuh', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'suhutubuh', array('class'=>'span1 float2')); ?>
                <label>&deg;C</label>
            </div>
        </div>
    </div>
</div>