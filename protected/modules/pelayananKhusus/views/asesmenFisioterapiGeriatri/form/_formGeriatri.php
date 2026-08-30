<?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasien_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienadmisi_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienmasukpenunjang_id',array('readonly' => true)); ?>

<p>&nbsp;</p>
    
<div class="control-group">        
    <div class="controls">
        <label>b. Test Khusus Sesuai Kelainan/Penyakit/Gangguan</label>
    </div>
</div>

 <div class="control-group">        

    <div class="controls">
        <?php echo $form->textArea($model,'test_khusus',array('class' => 'span7 autorow')) ?>    
    </div>
</div>     

