<?php $i = '';$no=''; ?>

<tr>
    <td>
        <?php echo $form->textField($model,'['.$i.']no',array('readonly'=>true,'style'=>'width:20px;','value'=>$no,'id'=>'REKomponenjasaM_no')) ?>
    </td>
    <td>
        <?php echo $form->dropDownList($model,'['.$i.']kelompoktindakan_id',CHtml::listData($model->getKelompoktindakanItems(),'kelompoktindakan_id','kelompoktindakan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:60px;')) ?>
    </td>
    <td>
        <?php echo $form->dropDownList($model,'['.$i.']ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:60px;')) ?>
    </td>
     <td>
        <?php echo $form->textField($model,'['.$i.']komponenjasa_kode',array('readonly'=>false,'style'=>'width:40px;')) ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']komponenjasa_nama',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'jasanama','style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']komponenjasa_singkatan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']besaranjasa',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']potongan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasadireksi',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']kuebesar',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasadokter',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasaparamedis',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasaunit',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasabalanceins',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']jasaemergency',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td>
        <?php echo $form->textField($model,'['.$i.']biayaumum',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
    </td>
    <td style="width:50px;">
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white">&nbsp;</i>','',array('class' => 'btn btn-primary','title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahKomponenjasa(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white">&nbsp;</i>','#',array('class' => 'btn btn-primary','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusKomponenjasa(this);return false','style'=>'cursor:pointer;')); ?>
    </td>
</tr>