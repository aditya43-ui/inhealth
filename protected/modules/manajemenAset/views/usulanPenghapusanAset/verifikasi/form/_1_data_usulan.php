<div class="col-sm-6">
    <?= $form->textFieldRow($model,'usulanpenghapusanaset_tanggal',['class'=>'span3','readonly'=>true]) ?>        
    <?= $form->textFieldRow($model,'usulanpenghapusanaset_nomor',['class'=>'span3','readonly'=>true]) ?>        
</div>

<div class="col-sm-6">    
    <?= $form->hiddenField($model,'pegpengusul_id') ?>
    <?= $form->textFieldRow($model,'pegpengusul_nama',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'lokasiaset_namalokasi',['class'=>'span3','readonly'=>true]) ?>                
</div>