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
			<div class="panel-title">Form Observasi Restraint</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($model,'tanggal' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tanggal',
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
						<?php echo $form->labelEx($model,'jam' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'jam',
								'mode' => 'time',
								'options' => array(
									// 'dateFormat' => Params::DATE_FORMAT,
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

					
				
				</div>
				<div class="col-sm-6">
					
				<div class="control-group">
						<?php echo $form->labelEx($model,'perawat_pengisi', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'perawat_pengisi',
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
												$("#'.CHtml::activeId($model, 'perawat_pengisi').'").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#perawat_pengisi").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogDilakukanOleh'),
									)); 
								?>
						</div>
					</div>

					<!-- <div class="control-group">
						<?php //echo $form->labelEx($model,'luka' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php //echo $form->textField($model,'luka',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div> -->
				
				</div>
			
			</div>

			
		</div>
	</div>	
</div>

<div class="row-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Data Observasi Restraint</div>
		</div>
		<div class="panel-body">
			<br>
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-darkk">
						<span class="group-title">
							TTV
						</span>
						<div class="panel-body">
							<div class="control-group">
								<?php echo CHtml::label('KES','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('kes','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo CHtml::label('TD','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('td','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo CHtml::label('HR','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('hr','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo CHtml::label('RR','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('rr','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo CHtml::label('S','' , array('class' => 'control-label')); ?>
								<div class="controls">
									<?php echo CHtml::textField('s','',array('size'=>60,'maxlength'=>200)); ?>
								</div>
							</div>
							
						</div>
					</div>
				
				</div>
				<div class="col-sm-6">
					<div class="panel panel-darkk">
						<span class="group-title">
							Lokasi Restrain
						</span>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="control-group">
										
										<div class="controls">
											<?php echo CHtml::checkbox('taka','',array('size'=>60,'maxlength'=>200)); ?>
											<?php echo $form->labelEx($model,'taka'); ?>
										</div>
									</div>
									<div class="control-group">
										
										<div class="controls">
											<?php echo CHtml::checkbox('taki','',array('size'=>60,'maxlength'=>200)); ?>
											<?php echo $form->labelEx($model,'taki'); ?>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="control-group">
										
										<div class="controls">
											<?php echo CHtml::checkbox('kaka','',array('size'=>60,'maxlength'=>200)); ?>
											<?php echo $form->labelEx($model,'kaka' ); ?>
										</div>
									</div>
									<div class="control-group">
										
										<div class="controls">
											<?php echo CHtml::checkbox('kaki','',array('size'=>60,'maxlength'=>200)); ?>
											<?php echo $form->labelEx($model,'kaki'); ?>
										</div>
									</div>
								</div>
							</div>
							
							
							<div class="control-group">
								<?php echo CHtml::label('&nbsp;','' , array('class' => 'control-label')); ?>
								<div class="controls">
								&nbsp;
								</div>
							</div>

						</div>
					</div>
					<br>
					<div class="panel panel-darkk">
						<span class="group-title">
							Luka <span style="color:red;">*</span>
						</span>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="control-group">	
										<div class="controls">
											<?php echo CHtml::radioButton('luka','',array('class'=>'luka_plus','value'=>'+','size'=>60,'maxlength'=>200)); ?>
											<?php echo Chtml::label('+',''); ?>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="control-group">	
										<div class="controls">
											<?php echo CHtml::radioButton('luka','',array('class'=>'luka_minus','value'=>'-','size'=>60,'maxlength'=>200)); ?>
											<?php echo Chtml::label('-',''); ?>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				
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
			<br>
			<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>No</th>
						<th>Kes</th>
						<th>TD</th>
						<th>HR</th>
						<th>RR</th>
						<th>S</th>
						<th>Taka</th>
						<th>Taki</th>
						<th>Kaka</th>
						<th>Kaki</th>
						<th>Luka</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if (!empty($model->observasipemasanganrestrain_id)){
				$modDetail = ObservasipemasanganrestraindetT::model()->findAllByAttributes(array('observasipemasanganrestrain_id'=>$model->observasipemasanganrestrain_id));
				if (count($modDetail) > 0){
					foreach ($modDetail as $i=>$data){?>
						<tr>
							<td><?= $i+1;?></td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']kes', array('class'=>'', 'readonly'=>TRUE)); echo $data->kes; ?> </td>       
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']td', array('class'=>'', 'readonly'=>TRUE)); echo $data->td; ?> </td>       
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']hr', array('class'=>'', 'readonly'=>TRUE)); echo $data->hr; ?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']rr', array('class'=>'', 'readonly'=>TRUE)); echo $data->rr; ?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']s', array('class'=>'', 'readonly'=>TRUE)); echo $data->s; ?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']taka', array('class'=>'', 'readonly'=>TRUE)); 
								if ($data->taka == true){
									echo CHtml::link('<i class="icon-form-check"></i>', '#');
								}
							?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']taki', array('class'=>'', 'readonly'=>TRUE)); 
								if ($data->taki == true){
									echo CHtml::link('<i class="icon-form-check"></i>', '#');
								}
							?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']kaka', array('class'=>'', 'readonly'=>TRUE)); 
								if ($data->kaka == true){
									echo CHtml::link('<i class="icon-form-check"></i>', '#');
								} 
							?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']kaki', array('class'=>'', 'readonly'=>TRUE)); 
								if ($data->kaki == true){
									echo CHtml::link('<i class="icon-form-check"></i>', '#');
								}
							?> </td>       
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']luka', array('class'=>'', 'readonly'=>TRUE)); echo $data->luka; ?> </td>       
							<td style="text-align:center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?></td>
						</tr>
					<?php }
				}}?>
				</tbody>
			</table>


		</div>
	</div>
</div>

	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->observasipemasanganrestrain_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPemasanganRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				//echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->observasipemasanganrestrain_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPemasanganRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				//echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
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
									$(\"#'.CHtml::activeId($model, 'perawat_pengisi').'\").val(\"$data->NamaLengkap\");
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
	   var hasiltaka = ' ';
	   var hasiltaki = ' ';
	   var hasilkaka = ' ';
	   var hasilkaki = ' ';
       var kes = $("#kes").val();
       var td = $("#td").val(); 
       var hr = $("#hr").val();
	   var rr = $("#rr").val();
	   var s = $("#s").val();
	   var taka = $("#taka").is(':checked');
	   var taki = $("#taki").is(':checked');
	   var kaka = $("#kaka").is(':checked');
	   var kaki = $("#kaki").is(':checked');
	   var luka = '';

	   
		if ($('.luka_plus').is(":checked")) {
			luka = '+';
		} else if ($('.luka_minus').is(":checked")){
			luka = '-';
		} 
	   if (taka == true){
		   var hasiltaka = '<?php echo CHtml::link('<i class="icon-form-check"></i>', '#') ?>'; 
	   }

	   if (taki == true){
		   var hasiltaki = '<?php echo CHtml::link('<i class="icon-form-check"></i>', '#') ?>'; 
	   }

	   if (kaka == true){
		   var hasilkaka = '<?php echo CHtml::link('<i class="icon-form-check"></i>', '#') ?>'; 
	   }

	   if (kaki == true){
		   var hasilkaki = '<?php echo CHtml::link('<i class="icon-form-check"></i>', '#') ?>'; 
	   }


	   
       var no = $("#riwayatrestrain tbody").find("tr").length;              
       
       $('#riwayatrestrain tbody').append("<tr>\n\
	   											<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_kes' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][no]' value = '"+(no+1)+"' >"+(no+1)+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_kes' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][kes]' value = '"+kes+"' >"+kes+"</td>"+
                                                "<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_td' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][td]' value = '"+td+"' >"+td+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_hr' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][hr]' value = '"+hr+"' >"+hr+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_rr' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][rr]' value = '"+rr+"' >"+rr+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_s' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][s]' value = '"+s+"' >"+s+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_taka' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][taka]' value = '"+taka+"' >"+hasiltaka+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_taki' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][taki]' value = '"+taki+"' >"+hasiltaki+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_kaka' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][kaka]' value = '"+kaka+"' >"+hasilkaka+"</td>"+
                                               "<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_kaki' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][kaki]' value = '"+kaki+"' >"+hasilkaki+"</td>"+
											   "<td><input readonly = TRUE type = 'hidden' id = 'ObservasipemasanganrestraindetT"+(no+1)+"_luka' name = 'ObservasipemasanganrestraindetT["+(no+1)+"][luka]' value = '"+luka+"' >"+luka+"</td>\n\
                                                <td style='text-align:center;'>"+buttonMinus+"</td>\n\
                                            </tr>");
    
       resetRiwayat();
    }
    
    function resetRiwayat()
    {
        $("#kes").val('');
        $("#td").val('');
        $("#tanda").val('');
        $("#hr").val('');
		$("#rr").val('');
		$("#s").val('');
		$("#taka").prop('checked',false);
		$("#taki").prop('checked',false);
		$("#kaka").prop('checked',false);
		$("#kaki").prop('checked',false);
		$(".luka_plus").prop('checked',false);
		$(".luka_minus").prop('checked',false);
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