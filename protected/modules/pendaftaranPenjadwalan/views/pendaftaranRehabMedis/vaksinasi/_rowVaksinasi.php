<?php

if (empty($model)) {
    $model = new RiwayatvaksinasipasienT();
}
// $model->jenisvaksin_id = empty($model->daftarvaksin->vaksin->jenisvaksin) ? null : $model->daftarvaksin->vaksin->jenisvaksin_id;
// $model->vaksin_id = empty($model->daftarvaksin->vaksin) ? null : $model->daftarvaksin->vaksin_id;
if (empty($idx)) {
    $idx = "iii";
}

$listJenis = CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama');
$listVaksin = array();
$listDaftar = array();

if (!empty($model->jenisvaksin_id)) {
    $listVaksin = CHtml::listData(VaksinM::model()->findAllByAttributes(array(
        'jenisvaksin_id'=>$model->jenisvaksin_id,
        'vaksin_aktif'=>true,
    ), array(
        'order'=>'imunisasi_program',
    )), 'vaksin_id', 'imunisasi_program');
}   

if (!empty($model->vaksin_id)) {
    $listDaftar = CHtml::listData(DaftarvaksinM::model()->findAllByAttributes(array(
        'vaksin_id'=>$model->vaksin_id,
        'daftarvaksin_aktif'=>true,
    ), array(
        'order'=>'daftarvaksin_nama',
    )), 'daftarvaksin_id', 'daftarvaksin_nama');
}

?>

<tr>
    <td>
        <?php
        $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'[detail]['.$idx.']vaksinasi_tanggal',
            'mode'=>'datetime',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
                'minDate' => 'd',
            ),
            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker4 span2 vaksinasi_tanggal input_req', 'onkeyup'=>"return $(this).focusNextInputField(event)", "style"=>"width:140px !important;"),
        ));
        ?>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$idx.']riwayatvaksinasipasien_id', array('class'=>'riwayatvaksinasipasien_id')); ?>
    </td>
    <td><?php echo CHtml::activeTextField($model, '[detail]['.$idx.']vaksinasi_ke', array('class'=>'span1 numbers-only vaksinasi_ke input_req')); ?></td>
    <td><?php echo CHtml::activeDropDownList($model, '[detail]['.$idx.']jenisvaksin_id', $listJenis, array('empty'=>'-- Pilih --', 'class'=>'span3 jenisvaksin_id list_jenisvaksin input_req', 'onchange'=>'setItemVaksin(this);')); ?></td>
    <td><?php echo CHtml::activeDropDownList($model, '[detail]['.$idx.']vaksin_id', $listVaksin, array('empty'=>'-- Pilih --', 'class'=>'span3 vaksin_id input_req', 'onchange'=>'setItemDaftarVaksin(this);')); ?></td>
    <td><?php echo CHtml::activeDropDownList($model, '[detail]['.$idx.']daftarvaksin_id', $listDaftar, array('empty'=>'-- Pilih --', 'class'=>'span3 daftarvaksin_id input_req')); ?></td>
    <td><?php echo CHtml::activeTextField($model, '[detail]['.$idx.']no_batch', array('class'=>'span2 no_batch')); ?></td>
    <td><?php echo CHtml::activeTextArea($model, '[detail]['.$idx.']vaksinasi_lokasimenerima', array('rows'=>3, 'class'=>'span3 vaksinasi_lokasimenerima input_req')); ?></td>
    <td><?php echo CHtml::button('-', array('class'=>'btn btn-danger', 'onclick'=>'hapusRowRiwayatVaksinasi(this)', 'rel' => 'tooltip', 'title' => 'Klik untuk menghapus Riwayat Vaksinasi/Imunisasi')); ?></td>
</tr>