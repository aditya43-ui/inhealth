<div class="form_pilih">
<?php 

if (!$model->isNewRecord) {
    $mod = KesejahteraanibuoksitosinT::model()->findByAttributes(array(
        'kesejahteraanibu_id'=>$model->kesejahteraanibu_id,
    ));
    if (empty($mod)) {
        $mod = new KesejahteraanibuoksitosinT;
    }
} else {
    $mod = new KesejahteraanibuoksitosinT;
}

echo '<strong>'.CHtml::checkBox('is_oksitosin', !$mod->isNewRecord, array('class'=>'form_pilih_ceklis'))." ".CHtml::label('Oksitosin', '', array('style'=>'font-weight: bold;', 'uncheckValue'=>null)).'</strong>';
?>
    <div class="form_pilih_content">
        <div class="control-group">
            <?php echo $form->label($mod, 'oksitosin_ul', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'oksitosin_ul', array('class'=>'span2')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->label($mod, 'oksitosin_lolos', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($mod, 'oksitosin_lolos', array('class'=>'span2')); ?>
            </div>
        </div>
    </div>
</div>