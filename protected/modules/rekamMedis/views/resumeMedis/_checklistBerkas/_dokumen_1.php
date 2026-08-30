<?php

    $dok_1 = ['KTP', 'Kode ICD', 'Kepala List', 'Form Cairan', 'Diagnosa Tindakan', 'Nama Dokter Operasi', 'Tanda Tangan Dokter', 'Nama Pasien',
             'Tanda Tangan Pasien', 'Nama Saksi 1', 'Tanda Tangan Saksi 1', 'Nama Saksi 2', 'Tanda Tangan Saksi 2'];
    $attr_1 = ['ktp', 'kodeicd', 'kepalalist', 'formcairan', 'diagnosatindakan', 'namadokteroperasi', 'tandatangandokter', 'namapasien',
             'tandatanganpasien', 'namasaksi1', 'tandatangansaksi1', 'namasaksi2', 'tandatangansaksi2'];

    $dok_2 = ['Discharge Sum', 'Form Operasi', 'Form Anestesi', 'Form Transfusi', 'Form Kematian', 'Form ASKEP', 'General Consent', 'Form IC'];
    $attr_2 = ['dischargesum', 'formoperasi', 'formanastesi', 'formtransfusi', 'formkematian', 'formaskep', 'generalconsent', 'formic'];

?>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label" style="width: 180px;">Tanggal Setor Dokumen RM</label>
        <div class="controls">
            <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
                        'value' => null,
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 realtime',
                        ),
                    ));
                ?>
        </div>
    </div><br>
    <table class="items table table-striped table-bordered table-condensed" style="width: 70%;">
        <thead>
            <tr>
                <th style="width: 10%;">No. </th>
                <th style="width: 60%;">Dokumen</th>
                <th>Checklist</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dok_1 as $i => $d1):?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $d1 ?></td>
                <td style="text-align: center;"><?php echo $form->dropDownList($model, $attr_1[$i], LookupM::getItems('checklistberkas_rm'), array('empty'=>'-- Pilih --','class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<div class="col-sm-6" style="margin-top: 53px;">
    <table class="items table table-striped table-bordered table-condensed" style="width: 70%;">
        <thead>
            <tr>
                <th style="width: 10%;">No. </th>
                <th style="width: 60%;">Dokumen</th>
                <th>Kelengkapan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dok_2 as $j => $d2):?>
            <tr>
                <td><?= $j + 1 ?></td>
                <td><?= $d2 ?></td>
                <td style="text-align: center;"><?php echo $form->dropDownList($model, $attr_2[$j], LookupM::getItems('kelengkapanberkas_rm'), array('empty'=>'-- Pilih --','class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>