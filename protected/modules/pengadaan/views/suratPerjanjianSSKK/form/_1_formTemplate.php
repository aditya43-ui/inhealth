<div class="col-sm-6">
    <?php 
        echo $form->dropDownListRow($model,'konfigtemplatesurat_id', CHtml::listData($dropSuratTemp,'konfigtemplatesurat_id','konfigtemplatesurat_nama'),array('empty'=>'-- Pilih --', 'class' => 'span3'));
        echo $form->textFieldRow($model,'syaratkhususkontrak_nomor',array('readonly' => true, 'class' => 'span3'));         
    ?>
</div>

<div class="col-sm-6">   
    <?php         
        echo $form->textFieldRow($model,'syaratkhususkontrak_tanggal',array('readonly' => true, 'class' => 'span3'));                 
        echo $form->textFieldRow($model,'nosuratperjanjiankerja',array('readonly' => true, 'class' => 'span3'));                 
    ?>
</div>