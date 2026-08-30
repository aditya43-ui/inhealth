<style>
	.table_pengisi, tr, td{
		vertical-align:top;
		padding: 10px;
	}

	.isian{
		margin-left : 10px;
	}

</style>
<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'tindakanrestraint-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

	
<div class="row-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Observasi dan Persetujuan Tindakan Restraint</div>
		</div>
		<div class="panel-body">
			<label>Dokter harus dihubungi terlebih dahulu untuk mengisi Aplikasi ini.</label>
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'tanggal_pengkajian' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tanggal_pengkajian',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									//'maxDate' => 'd',
								),
								'htmlOptions' => array(
									'readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'class'=>'span3',
								),
							));
							?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'dilakukanoleh', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'dilakukanoleh',
										'model' => $model,
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'dilakukanoleh').'").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#dilakukanoleh").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogDilakukanOleh'),
									)); 
								?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'dihubungi' , array('class' => 'control-label')); ?>
						<div class="controls">
							<div class="form-inline">
								<?php echo $form->radioButtonList($model,'dihubungi',array('1'=>' Ya ','0'=>' Tidak '), array('onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'margin-left:5px;','class'=>'','onclick'=>'cekresusitasi()')); ?>  
							</div>	
						</div>
					</div>
				
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'pengkajian_restrain' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'pengkajian_restrain',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'dokteryang_merawat', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'dokteryang_merawat',
										'model' => $model,
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'dokteryang_merawat').'").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogDokterMerawat'),
									)); 
								?>
						</div>
					</div>
				
				</div>
			
			</div>

			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Restraint</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="control-group">
								<?php echo CHtml::label('Tipe Restrain','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('tiperestrain','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo CHtml::label('Lamanya Restrain','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('lamarestrain','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>

						</div>

						<div class="col-sm-6">
							<div class="control-group">
								<?php echo CHtml::label('Frekuensi Evaluasi Penggunaan Restrain','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('frekuensirestrain','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>

							<div class="control-group">
								<div class="control-label">
                                        <?php
                                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                            array('onclick' => 'inputRestrain();',
                                                'class' => 'btn btn-primary',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'rel' => "tooltip",
                                                'title' => "Klik untuk menambahkan detail pemberian obat",));
                                        ?> 
								</div>
                            </div>

						</div>
					</div>

					<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>Tipe Restrain</th>
								<th>Lamanya Restrain</th>
								<th>Frekuensi Evaluasi Penggunaan Restrain (Minimal setiap 24 Jam)</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						if (!empty($model->observasirestrain_id)){
						$modDetail = ObservasirestraindetT::model()->findAllByAttributes(array('observasirestrain_id'=>$model->observasirestrain_id));
						if (count($modDetail) > 0){
							foreach ($modDetail as $i=>$data){?>
								<tr>
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']tiperestrain', array('class'=>'', 'readonly'=>TRUE)); echo $data->tiperestrain; ?> </td>       
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']lamarestrain', array('class'=>'', 'readonly'=>TRUE)); echo $data->lamarestrain; ?> </td>       
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']frekuensirestrain', array('class'=>'', 'readonly'=>TRUE)); echo $data->frekuensirestrain; ?> </td>       
									<td style="text-align:center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?></td>
								</tr>
							<?php }
						}}?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>	
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Persetujuan Oleh dokter yang merawat</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<label>Saya menyetujui tindakan pengekangan (restrain) berdasarkan pada:</label>
				</div>

				<div class='control-group'>
					<?php $data = array("Observasi",
										"Informasi/komunikasi dengan perawat",
										"Komunikasi antar tim kesehatan"
					);
				
					if (!empty($model->persetujuanolehdokter)){
						$model->persetujuanolehdokter = json_decode($model->persetujuanolehdokter);	
					}?>
					<div class='controls'>
						<?php $index = 0;
							foreach ($data as $val => $label): ?>
						<div>
							<?php echo $form->checkBox($model, 'persetujuanolehdokter['.$index.']', array('value'=>$label, 'class'=>'pilihanresus')); ?>
							<label ><?= $label ?></label>
						</div>
						<?php $index++; endforeach; ?>
					</div>
				</div>

				<div class="control-group">
						<?php echo $form->labelEx($model,'dokter_persetujuan', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'dokter_persetujuan',
										'model' => $model,
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'dokter_persetujuan').'").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogPersetujuan'),
									)); 
								?>
						</div>
					</div>

					<div class="control-group">
						<?php echo $form->labelEx($model,'saksi', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'saksi',
										'model' => $model,
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'saksi').'").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogSaksi'),
									)); 
								?>
						</div>
					</div>

			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Dokter Pemberi dan Penerima informasi</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<?php echo $form->labelEx($model,'pemberi_informasi', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php 
								$this->widget('MyJuiAutoComplete', array(
									'attribute'=>'pemberi_informasi',
									'model' => $model,
									'source'=>'js: function(request, response) {
										$.ajax({
											url: "'.$this->createUrl('getPegawai').'",
											dataType: "json",
											data: {
												term: request.term,
											},
											success: function (data) {
												response(data);
											}
										})
									}',
									'options'=>array(
										'showAnim'=>'fold',
										'minLength' => 2,
										'focus'=> 'js:function( event, ui ) {
											$(this).val( ui.item.label);
											return false;
										}',
										'select'=>'js:function( event, ui ) {
											$("#'.CHtml::activeId($model, 'pemberi_informasi').'").val(ui.item.label); 
											return false;
										}',
								),
									'htmlOptions'=>array(
										'onkeyup'=>"return $(this).focusNextInputField(event)",
										'class'=>'span3',
										'onblur' => 'if(this.value === "") $("#petugas_kerohanian").val(""); '
									),
									'tombolDialog'=>array('idDialog'=>'diaglogPetugas'),
								)); 
							?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model,'penerima_informasi' , array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'penerima_informasi',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>

			</div>
		</div>
	
	</div>
	<div class="col-sm-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Pemberitahuan kepada keluarga</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<?php echo $form->labelEx($model,'iskeluarga_diberitahu' , array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="form-inline">
							<?php echo $form->radioButtonList($model,'iskeluarga_diberitahu',array('1'=>' Ya ','0'=>' Tidak '), array('onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'margin-left:5px;','class'=>'','onclick'=>'cekresusitasi()')); ?>  
						</div>	
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($model,'nama_keluarga' , array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'nama_keluarga',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($model,'hubungan_keluarga' , array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'hubungan_keluarga',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label('Kebutuhan Restrain','' , array('class' => 'control-label')); ?>
					<div class="controls">
						<div class="form-inline">
							<?php echo $form->checkbox($model,'kebutuhan_restrain_fisik'); ?>&nbsp;<label>Fisik</label>
							&nbsp;&nbsp;
							<?php echo $form->checkbox($model,'kebutuhan_restrain_fisik'); ?>&nbsp;<label>Obat - obatan</label>
						</div>	
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($model,'tujuan_restrain' , array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'tujuan_restrain',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>
			</div>
		</div>
	
	</div>

</div>


	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->observasirestrain_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexTindakanRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->observasirestrain_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexTindakanRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
			}?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogDilakukanOleh',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'dilakukanoleh').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogDilakukanOleh\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogDokterMerawat',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'dokteryang_merawat').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogDokterMerawat\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPersetujuan',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'dokter_persetujuan').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPersetujuan\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogSaksi',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'saksi').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogSaksi\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugas',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#'.CHtml::activeId($model, 'pemberi_informasi').'\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugas\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<script>


function inputRestrain()
    {
       var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?>'; 
       var tiperestrain = $("#tiperestrain").val();
       var lamarestrain = $("#lamarestrain").val(); 
       var frekuensirestrain = $("#frekuensirestrain").val(); 
       var no = $("#riwayatrestrain tbody").find("tr").length;              
       
       $('#riwayatrestrain tbody').append("<tr>\n\
                                                <td><input readonly = TRUE type = 'hidden' id = 'ObservasirestraindetT"+(no+1)+"_tiperestrain' name = 'ObservasirestraindetT["+(no+1)+"][tiperestrain]' value = '"+tiperestrain+"' >"+tiperestrain+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'ObservasirestraindetT"+(no+1)+"_lamarestrain' name = 'ObservasirestraindetT["+(no+1)+"][lamarestrain]' value = '"+lamarestrain+"' >"+lamarestrain+"</td>"+
                                               "<td><input readonly = TRUE type = 'hidden' id = 'ObservasirestraindetT"+(no+1)+"_frekuensirestrain' name = 'ObservasirestraindetT["+(no+1)+"][frekuensirestrain]' value = '"+frekuensirestrain+"' >"+frekuensirestrain+"</td>\n\
                                                <td style='text-align:center;'>"+buttonMinus+"</td>\n\
                                            </tr>");
    
       resetRiwayat();
    }
    
    function resetRiwayat()
    {
        $("#tiperestrain").val('');
        $("#lamarestrain").val('');
        $("#tanda").val('');
        $("#frekuensirestrain").val('');
    }
    
    function delRow(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data detail ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });
        
    }


    
    
    
</script>