<div class="col-sm-6">    
    <?= $form->textFieldRow($model,'tgl_pengajuan',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'no_pengajuan',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'nominal_kasbon',['class'=>'span3 integer2','readonly'=>true]) ?>    
</div>

<div class="col-sm-6">
    <?= $form->hiddenField($model,'pegawai_mengajukan_id',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'pegawai_mengajukan_nama',['class'=>'span3','readonly'=>true]) ?>
    <?php //echo $form->textFieldRow($model,'nip',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'unitkerja_nama',['class'=>'span3','readonly'=>true]) ?>
</div>