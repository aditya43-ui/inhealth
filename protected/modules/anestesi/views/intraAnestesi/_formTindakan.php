<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanAnestesi($('#form-datakunjungan')); ")); ?>
<table class="items table table-striped table-condensed" id="table-tindakan">        
	<thead>
		<tr>
			<th>No.</th>
			<th>Jenis Anestesi</th>
			<th>Anestesi</th>
			<th>Jumlah</th>
			<th>Satuan</th>
			<th>Tarif</th>
			<th>Total Tarif</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
