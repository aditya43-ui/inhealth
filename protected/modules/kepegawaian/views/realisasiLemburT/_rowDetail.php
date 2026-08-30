<?php
$listLembur = BiayalemburM::model()->findAll(array(
    'order' => 'biayalembur_id',
));

$option = array();

foreach ($listLembur as $item) {
    $option[$item->biayalembur_id] = array(
        'data-biasa' => $item->biayalembur_nilai,
        'data-libur' => $item->biayalembur_nilailibur,
    );
}

$listDataLembur = CHtml::listData($listLembur, 'biayalembur_id', 'biayalembur_nama');
?>

<tr>
    <td width="3%" style="text-align: center">
        <?php echo CHtml::activeTextField($modRealisasiLemburDetail, '[detail][ii]nourut', array('readonly' => true, 'class' => 'span1 integer nourut', 'style' => 'width:20px;')); ?>
    </td>
    <td width="15%"><?php echo CHtml::activeHiddenField($modRealisasiLemburDetail, '[detail][ii]pegawai_id', array('readonly' => true, 'class' => 'integer pegawai_id')) ?>
        <?php $this->widget('MyJuiAutoComplete', array(
            'model' => $modRealisasiLemburDetail,
            'attribute' => '[detail][ii]nomorindukpegawai',
            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('GetPegawai') . '",
											   dataType: "json",
											   data: {
												   term_nip: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
            'options' => array(
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
                'select' => 'js:function( event, ui ) {
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
            ),
            'tombolDialog' => array('idDialog' => 'dialogPasienBadak', 'jsFunction' => "setDialogPegawai(this);"),
            'htmlOptions' => array(
                'placeholder' => 'NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'nip'
            ),
        ));
        ?>
    </td>
    <td width="15%">
        <?php $this->widget('MyJuiAutoComplete', array(
            'model' => $modPegawai,
            'attribute' => '[ii]nama_pegawai',
            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('GetPegawai') . '",
											   dataType: "json",
											   data: {
												   term_nama: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
            'options' => array(
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
                'select' => 'js:function( event, ui ) {
										$(this).val( ui.item.value);
										setPegawaiAuto(ui.item.pegawai_id,"1",$(this).parents("tr"));
										return false;
									}',
            ),
            'tombolDialog' => array('idDialog' => 'dialogPasienBadak', 'jsFunction' => "setDialogPegawai(this);"),
            'htmlOptions' => array(
                'placeholder' => 'Nama Pegawai', 'rel' => 'tooltip', 'title' => 'Ketik Nama Pegawai untuk mencari pasien',
                'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'nama_pegawai'
            ),
        ));
        ?>
    </td>
    <td nowrap><?php echo $this->renderPartial($this->path_view . '_jam2', array('idx' => 'ii', 'jam' => 'mulai', 'value' => "00:00:00"), true); ?></td>
    <td nowrap><?php echo $this->renderPartial($this->path_view . '_jam2', array('idx' => 'ii', 'jam' => 'selesai', 'value' => "00:00:00"), true); ?></td>
    <td width="12%" hidden><?php echo CHtml::activeDropDownList($modRealisasiLemburDetail, '[detail][ii]biayalembur_id', $listDataLembur, array('options' => $option, 'class' => 'span2 biayalembur_id', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNilaiLembur();')); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]totalJam', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span1  totalJam', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td width="6%"><?php echo CHtml::activeDropDownList($modRealisasiLemburDetail, '[detail][ii]total_jam_normal', [5 => "5", 7 => "7", 8 => "8"], array('style' => 'text-align: right;', 'value' => "", 'class' => 'span1  total_jam_normal', 'readonly' => false, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNilaiLembur();')); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]upah_bulanan', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span2 upah_bulanan', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]upah_lembur_jam1', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span2 upah_lembur_jam1', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]upah_lembur_jam2', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span2 upah_lembur_jam2', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]upah_lembur_jam3', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span2 upah_lembur_jam3', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td width="6%"><?php echo CHtml::activetextField($modRealisasiLemburDetail, '[detail][ii]totalNilai', array('style' => 'text-align: right;', 'value' => "", 'class' => 'span2 totalNilai', 'readonly' => true, 'maxLength' => 5, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
    <td>
        <?php echo CHtml::activeTextArea($modRealisasiLemburDetail, '[detail][ii]alasanlembur', array('class' => 'span3 alasanLembur', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 499, 'readonly' => false)); ?>
    </td>
    <td width="6%" style="text-align: center;">
        <?php
        echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick' => 'cancelRow(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan pegawai'));
        ?>
    </td>
</tr>