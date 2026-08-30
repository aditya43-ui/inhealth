<?php 
    $i = (isset($i) ? $i : 'ii' );
    $no = '';
?>
    <tr>
    <td><?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?></td>
    <td>
        <?php echo $form->textField($modReferensiKerja,'['.$i.']namareferensi',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 isDetailReq3')); ?>
    </td>
    <td>
        <?php echo $form->textField($modReferensiKerja,'['.$i.']instansi',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 isDetailReq3')); ?>
    </td>
    <td>
        <?php echo $form->textField($modReferensiKerja,'['.$i.']jabatan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 isDetailReq3')); ?>
    </td>
    <td>
        <?php echo $form->textField($modReferensiKerja,'['.$i.']no_telp',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 isDetailReq3')); ?>
    </td>
    <td style="width:50px;">
        <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','javascript:void(0)',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahReferensikerja();return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','javascript:void(0)',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusReferensikerja(this);return false','style'=>'cursor:pointer;')); ?>
    </td>
</tr>