<?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasien_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienadmisi_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienmasukpenunjang_id',array('readonly' => true)); ?>

<div class="col-sm-6">
    <?php echo $form->textAreaRow($model,'penilaian_lukabakar',array('class' => 'span3')) ?>
    <?php echo $form->textAreaRow($model,'measurement_edema',array('class' => 'span3')) ?>
</div>

<div class="col-sm-6">
    <?php echo $form->textAreaRow($model,'test_khusus',array('class' => 'span3')) ?>
</div>