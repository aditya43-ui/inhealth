<fieldset>
	<table id="tblDiagnosaPasien" class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>Tgl. Diagnosa</th>
				<th>Kelompok Diagnosa</th>
				<th>Kode</th>
				<th>Nama Diagnosa</th>
				<th>Nama Lain</th>
				<th>Kata Kunci</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(!empty($listMorbiditas)){
				foreach ($listMorbiditas as $i => $morbiditas) { ?>
					<tr>
						<td><?php echo $morbiditas->tglmorbiditas; ?></td>
						<td>
							<?php echo $morbiditas->kelompokdiagnosa->kelompokdiagnosa_nama; ?>
							<?php //echo CHtml::dropDownList("VMorbiditas[$i][VkelompokDiagnosa]",$morbiditas->kelompokdiagnosa_id,CHtml::listData(RJKelompokDiagnosaM::model()->findAll(), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
									//                        array('class'=>'span2','disabled'=>true)); ?>
						</td>
						<td><?php echo $morbiditas->diagnosa->diagnosa_kode; ?></td>
						<td>
							<?php echo CHtml::hiddenField("VMorbiditas[$i][Vdiagnosa]", $morbiditas->diagnosa_id, array('readonly'=>true,'class'=>'span1 idDiagnosa','disabled'=>true)); ?>
							<?php echo $morbiditas->diagnosa->diagnosa_nama; ?>
						</td>
						<td><?php echo $morbiditas->diagnosa->diagnosa_namalainnya; ?></td>
						<td><?php echo $morbiditas->diagnosa->diagnosa_katakunci; ?></td>
					</tr>
				<?php } 
				}
			?>
		</tbody>
	</table>
</fieldset>