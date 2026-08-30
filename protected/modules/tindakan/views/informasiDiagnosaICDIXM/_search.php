<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'diagnosaicdix_kode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosaicdix_kode', array('placeholder' => 'Kode Diagnosa', 'class' => 'span3 angkadot-only', 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'diagnosaicdix_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'diagnosaicdix_nama', array('placeholder' => 'Nama Diagnosa', 'class' => 'span3 custom-only', 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); 
?>
<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>50)); 
?>

<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); 
?>

<?php //echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); 
?>