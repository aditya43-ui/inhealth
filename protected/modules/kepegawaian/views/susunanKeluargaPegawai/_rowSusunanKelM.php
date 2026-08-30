<?php
$i = (isset($i) ? $i : '');
?>
<tr>
    <td style="padding-right: 0;">
        <?php echo $form->textField($model, '[' . $i . ']nourutkel', array('class' => 'span1 pegawai integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td style="text-align: center;">
        <?php echo $form->checkbox($model, '[' . $i . ']istanggungan', array('class' => 'istanggungan', 'onkeypress' => "return $(this).focusNextInputField(event);",'checked'=>false)); ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']nopesertabpjs', array('class' => 'span3 nopesertabpjs', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']no_kartu_keluarga', array('class' => 'span3 no_kartu_keluarga', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($model, '[' . $i . ']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class' => 'span2 hubkeluarga', 'onchange' => 'setDefaultJenisKelamin(this); setDefaultPernikahan(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php //echo $form->textField($model,'['.$i.']hubkeluarga',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
        ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']susunankel_nama', array('class' => 'span2', 'onchange' => '$(this).val($(this).val().toUpperCase());', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?></td>
    <td>
        <?php echo $form->dropDownList($model, '[' . $i . ']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class' => 'span2 jeniskelamin', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']susunankel_tempatlahir', array('class' => 'span2', 'onchange' => '$(this).val($(this).val().toUpperCase());', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
    </td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[' . $i . ']susunankel_tanggallahir',
            'mode' => 'date',
            'options' => array(
                'showOn' => false,
                // 'maxDate' => 'd',
                'yearRange' => "-150:+0",
            ),
            'htmlOptions' => array(
                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
            ),
        )); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($model, '[' . $i . ']pekerjaan_nama', CHtml::listData(PekerjaanM::model()->findAll('pekerjaan_aktif = true'), 'pekerjaan_nama', 'pekerjaan_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($model, '[' . $i . ']pendidikan_nama', CHtml::listData(PendidikanM::model()->findAll('pendidikan_aktif = true'), 'pendidikan_nama', 'pendidikan_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
    </td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '[' . $i . ']susunankel_tanggalpernikahan',
            'mode' => 'date',
            'options' => array(
                'showOn' => false,
                'maxDate' => 'd',
                'yearRange' => "-150:+0",
            ),
            'htmlOptions' => array(
                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask pernikahan', 'onkeyup' => "return $(this).focusNextInputField(event)"
            ),
        )); ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']susunankel_tempatpernikahan', array('class' => 'span2 pernikahan', 'onchange' => '$(this).val($(this).val().toUpperCase());', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
    </td>
    <td>
        <?php echo $form->textField($model, '[' . $i . ']susunankeluarga_nip', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahOrganisasi(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('style' => 'display:none;', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusOrganisasi(this);return false', 'style' => 'cursor:pointer;')); ?>
    </td>
</tr>