<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'penolakanresusitasi-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

	
<div class="row-fluid">
	<div class="col-sm-12">
		<div class="control-group" hidden>
			<?php echo $form->labelEx($model,'pendaftaran_id', array('class' => 'control-label')); ?>
			<?php echo $form->textField($model,'pendaftaran_id'); ?>
			<?php echo $form->error($model,'pendaftaran_id'); ?>
		</div>

		
		<div class="control-group">
			<?php echo CHtml::label('Diagnosa','', array('class' => 'control-label')); ?>
			<div class="controls">
				<div style="border:1px solid; width:400px; height:150px; padding:5px;">
					<table width="100%">
						<tr>
							<td width="60px"><label>Utama</label></td>
							<td width="10px;"><label>: </label> </td>
							<?php $data1 = '';?>
							<?php $data2 = '';?>
							<td><?php foreach ($modDiagnosa as $key => $value) {
								if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA){
									echo "<label>".$value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama."</label>";
									$data1 = $value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama;
								}
							}?> </td>
						</tr>
						<tr>
							<td><label>Tambahan</label></td>
							<td><label>: </label> </td>
							<td>
							<?php foreach ($modDiagnosa as $key => $value) {
								if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH){
									echo "<label>".$value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama."</label>";
									$data2 = $value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama;
								}
							}?>
							</td>
						</tr>
						<?php echo $form->hiddenField($model,'diagnosaresusitasi[utama]', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'value'=>$data1)); ?>
						<?php echo $form->hiddenField($model,'diagnosaresusitasi[tambahan]', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'value'=>$data2)); ?>
					
					</table>
					
				
				</div>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Status Resusitasi</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Apakah pasien butuh resusitasi atau bantuan hidup dasar',''); ?>
							<?php echo $form->radioButtonList($model,'pasienbutuh_resusitasi',array('1'=>' Ya ','0'=>' Tidak '), array('onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'margin-left:5px;','class'=>'','onclick'=>'cekresusitasi()')); ?>  
						</div>	
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Jika tidak, berikan alasan',''); ?>
							<?php echo $form->textField($model,'resusitasi_tidak', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>	
					</div>
				</div>

				<div class='control-group'>
					<?php $data = array("Kondisi pasien mengindikasikan bahwa resusitasi atau bantuan hidup dasar tidak mungkin efektif atau berhasil",
										"Pasien menolak dilakukan resusitasi atau bantuan hidup dasar",
										"Alasan lain, "
					);
				
					if (!empty($model->resusitasi_lainnya)){
						$model->resusitasi_lainnya = json_decode($model->resusitasi_lainnya);	
					}?>
					<div class='controls'>
						<?php $index = 0;
							foreach ($data as $val => $label): 
							
							$det = TindakanresusitasiT::model()->findByAttributes(array(
								'tindakanresusitasi_id'=>$model->tindakanresusitasi_id
							));
							
							if (empty($det)) {
								$det = new TindakanresusitasiT;
								$det->resusitasistatus = $label;
							}
							
							?>
						<div>
							

							<?php if ($label == "Alasan lain, "){?>
								<?php echo $form->checkBox($model, 'resusitasistatus['.$index.']', array('value'=>$label, 'class'=>'pilihanresus')); ?>
								<label ><?= $label ?></label>
								<?php echo $form->textField($model, 'resusitasi_lainnya', array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>

							<?php } else { ?>
								<?php echo $form->checkBox($model, 'resusitasistatus['.$index.']', array('value'=>$label, 'class'=>'pilihanresus')); ?>
								<label ><?= $label ?></label>

							<?php }?>
						</div>
						<?php $index++; endforeach; ?>
					</div>
				</div>


			</div>
		</div>		

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Komunikasi</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Diskusikan dengan pasien',''); ?>
							<?php echo $form->radioButtonList($model,'isdiskusidengan_pasien',array('1'=>' Ya ','0'=>' Tidak '), array('onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'margin-left:5px;','class'=>'','onclick'=>'diskusipasien()')); ?>  
							
						</div>	
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Jika tidak, berikan alasan',''); ?>
							
							<?php echo $form->textField($model,'diskusipasien_tidak', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>	
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Diskusikan dengan keluarga pasien',''); ?>
							<?php echo $form->radioButtonList($model,'isdiskusidengan_keluarga',array('1'=>' Ya ','0'=>' Tidak '), array('onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'margin-left:5px;','class'=>'','onclick'=>'diskusikeluarga()')); ?>  
						</div>	
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<div class="form-inline">
							<?php echo CHtml::label('Jika tidak, berikan alasan',''); ?>
							<?php echo $form->textField($model,'diskusikeluarga_tidak', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>	
					</div>
				</div>
			</div>
		</div>		

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Data Pengisi</div>
			</div>
			<div class="panel-body">
				<div class="control-group">
					<?php echo $form->labelEx($model,'penerima_informasi', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo CHtml::activeDropDownList($model,'penerima_informasi', array('Pasien'=>'Pasien','Keluarga'=>'Keluarga'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'cekMenyatakan();')); ?>
					
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model,'nama_penerima' , array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'nama_penerima',array('size'=>60,'maxlength'=>200)); ?>
					</div>
				</div>

			</div>
		</div>		

		

		
	</div>
</div>

		




	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->tindakanresusitasi_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPenolakanResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->tindakanresusitasi_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPenolakanResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
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
    'id'=>'diaglogPetugas',
    'options'=>array(
        'title'=>'Daftar Pegawai Triase',
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
								  $(\"#petugas_nama\").val(\"$data->NamaLengkap\");
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



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugasruangan',
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
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugasruangan_id').'\").val(\"$data->pegawai_id\");  
								  $(\"#dokter_opinion\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugasruangan\').dialog(\'close\');return false;"))',
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
