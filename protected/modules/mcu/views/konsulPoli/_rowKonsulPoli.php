<table class="items table table-striped table-bordered table-condensed" id="tabel-konsultasi">
    <thead>
        <tr>
            <th>Dokter Konsul</th>
            <th>Tgl. Konsul</th>
            <th>Poliklinik Tujuan</th>
            <th>Catatan Dokter</th>
            <th>Kirim Pasien</th>
        </tr>
    </thead>
    <tbody>
<tr id="trPeriksaLabKosong">
			<td><?php echo CHtml::activeDropDownList($modKonsul, 'pegawai_id', CHtml::listData(DokterV::model()->findAll(),'pegawai_id','nama_pegawai'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','empty'=>'-- Pilih --')) ?></td>
			<td><div class="input-append"><?php echo CHtml::activeTextField($modKonsul, 'tglkonsulpoli', array('readonly'=>true,'class'=>'tanggal dtPicker2', 'style'=>'float:left;','value'=>date('Y-m-d H:i:s'))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div></td>
			<td><?php echo CHtml::activeDropDownList($modKonsul, 'ruangan_id', CHtml::listData(RuanganM::model()->getRuanganByInstalasi(PARAMS::INSTALASI_ID_RJ),'ruangan_id','ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','empty'=>'-- Pilih --')) ?></td>
			<td><?php echo CHtml::activeTextArea($modKonsul, 'catatan_dokter_konsul',array())?></td>
	<td>
		<?php
			if(!empty($modKonsul->konsulpoli_id)){
				echo "Tanggal Kirim : ".MyFormatter::formatDateTimeForUser($modKonsul->tglkonsulpoli);
				echo "Ke Ruangan : ".$modKonsul->politujuan->ruangan_nama;
			}else{
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="entypo-check"></i>')),
			array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
		<?php } ?>
	</td>
</tr>
    </tbody>
</table>
