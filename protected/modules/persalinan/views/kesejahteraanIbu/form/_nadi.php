<div class="form_pilih">
<?php 

if (!$model->isNewRecord) {
    $mod = KesejahteraanibunaditdT::model()->findByAttributes(array(
        'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
    ));
    if (empty($mod)) {
        $mod = new KesejahteraanibunaditdT;
    }
} else {
    $mod = new KesejahteraanibunaditdT;
}

echo '<strong>'.CHtml::checkBox('is_nadi', !$mod->isNewRecord, array('class'=>'form_pilih_ceklis'))." ".CHtml::label('Nadi & Tekanan Darah', '', array('style'=>'font-weight: bold;', 'uncheckValue'=>null)).'</strong>';
?>
    <div class="form_pilih_content">
        <div class="control-group">
            <?php echo $form->label($mod, 'nadi', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'nadi', array('class'=>'span1 numbers-only')); ?>
                <label> x/Menit</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($mod, 'td_systolic', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'td_systolic', array('class'=>'span1 numbers-only')); ?>
                <label>/</label>
                <?php echo $form->textField($mod, 'td_diastolic', array('class'=>'span1 numbers-only')); ?>
                <label>mmHg</label>
            </div>
        </div>
    </div>
</div>