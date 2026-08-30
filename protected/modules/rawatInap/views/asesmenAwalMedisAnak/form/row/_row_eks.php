<?php
$i = !empty($i)?$i:0;
?>
<tr class="baris">
    <td>
        <div class="control-group">
            <?= CHtml::activeHiddenField($model, '['.$i.']hasilpemeriksaanlabeksternal_id',['class'=>'hasilpemeriksaanlabeksternal_id det_id']) ?>
            <?= CHtml::activeDropDownList($model, '['.$i.']nama_pemeriksaan', $drop,['empty'=>'-- Pilih --','class'=>'required']) ?>
        </div>
    </td>
    <td>
        <?php           
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => "[".$i."]tgl_pemeriksaan",
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class' => 'span3 tanggal',
                    'style' => 'float:left',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
        ?>  
    </td>
    <td>
        <div class="control-group">
            <?= CHtml::activeTextArea($model, '['.$i.']hasil_pemeriskaan') ?>
        </div>
    </td>
    <td>
        <?= CHtml::link("<i class='fa fa-minus 2x'></i>",'javascript:;',['onclick'=>'hapus_data_baris(this)','class'=>'btn btn-danger','style'=>'border-radius:50%;padding:5px;color:#fff !important;','rel'=>'tooltip','title'=>'Tambah pemeriksaan hasil lab eksternal','data-placement'=>'left']) ?>
    </td>
</tr>