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
	'id'=>'tidakresusitasi-t-form',
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

		<div class="row">
			<div class="col-sm-12">
				<label>Formulir ini adalah perintah dokter penanggungjawab pasien (DPJP) kepada seluruh staf klinis rumah sakit agar tidak
				melakukan resusitasi terhadap pasien ini bila terjadi henti jantung (bila tidak ada denyut nadi) dan henti nafas ( tidak ada
				pernapasan spontan).
				Formulir ini juga memberikan perintah kepada staf medis untuk tetap melakukan intervensi, pegobatan, atau tatalaksana
				lainya sebelum terjadinya henti jantung atau henti nafas.</label>
			</div>
		</div>
		<br>
		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'nama_pasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'nama_pasien',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'tanggal_lahir' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modPasien,
					'attribute' => 'tanggal_lahir',
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
			<?php echo $form->labelEx($modPasien,'no_rekam_medik' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'no_rekam_medik',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($modPasien,'alamat_pasien' , array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modPasien,'alamat_pasien',array('size'=>60,'maxlength'=>200, 'readonly'=>true)); ?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<label>Saya dokter ang bertanggungjawab di bawah ini menginstruksikan kepada seluruh staf medis dan staf klinik lainnya untuk 
				melakukan hal-hal tertulis dibawah ini :</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="isian">
					<label>- Usaha komprehensif untuk mencegah henti jantung atau henti nafas tanpa melakukan intubasi. Jangan melakukan tindakan resusitasi jantung paru (RJP) jika
					terjadi henti nafas atau henti jantung.</label>
					<label>- Usaha suportif sebelum terjadi henti nafas atau henti jantung yang meliputi pembukaan jalan nafas non invasi, mengontrol pendarahan, memposisikan pasien 
					dengan nyaman, pemberian obat-obatan anti nyeri. Jangan melakukan tindakan resusitasi jantung paru (RJP) jika terjadi henti nafas atau henti jantung.</label>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div>
				<label>Saya dokter yang bertanda tangan di bawah menyatakan bahwa keputusan DNR diatas diambil setelah pasien diberikan penjelasan
				dan informed consent diperoleh dari salah satu :</label>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="isian">
					<label>- Pasien </label><br>
					<label>- Tenaga kesehatan yang ditunjuk pasien</label><br>
					<label>- Wali yang sah pasien (termasuk yang ditunjuk oleh pengadilan)</label><br>
					<label>- Anggota keluarga pasien</label><br>
					<label>- Jika yang diatas tidak dimungkinkan maka dokter yang bertanda tangan dibawah ini memberikan perintah DNR berdasarkan pada intruksi sebelumnya</label>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div>
				<label>Keputusan dua orang dokter yang menyatakan bahwa Resusitasi Jantung Paru akan mendatangkan hasil yang tidak efektif.</label>
				</div>
				
			</div>
		</div>

		
		

		
	</div>	
</div>
		<div style="width:50%">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Data yang bertanggungjawab</div>
				</div>
				<div class="panel-body">

					<div class="control-group">
						<?php echo $form->labelEx($model,'tanggal_pengisian' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tanggal_pengisian',
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
						<?php echo $form->labelEx($model,'nama_dokter', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'nama_dokter',
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
												$("#'.CHtml::activeId($model, 'nama_dokter').'").val(ui.item.label); 
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
						<?php echo $form->labelEx($model,'nip' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'nip',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo $form->labelEx($model,'no_tlp' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo $form->textField($model,'no_tlp',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
				</div>
			</div>
		</div>


	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->perintahsresusitasi_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPerintahTidakResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->perintahsresusitasi_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPerintahTidakResusitasi',array('pendaftaran_id'=>$model->pendaftaran_id)),
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
									$(\"#'.CHtml::activeId($model, 'nama_dokter').'\").val(\"$data->NamaLengkap\");
									$(\"#'.CHtml::activeId($model, 'nip').'\").val(\"$data->nomorindukpegawai\");
									$(\"#'.CHtml::activeId($model, 'no_tlp').'\").val(\"$data->notelp_pegawai\");
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
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'type'=>'raw',
                'value' => function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                    if(!empty($j)){
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawaiTriase, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),
            array(
                'header' => 'Kelompok Pegawai',
                'name' => 'kelompokpegawai_id',
                'type'=>'raw',
                'value' => function($data){
                    $k = KelompokpegawaiM::model()->findByPk($data->kelompokpegawai_id);
                    
                    if(!empty($k)){
                        return $k->kelompokpegawai_nama;
                    }else{
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawaiTriase, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC"), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => '-- Pilih --'))
            ),             
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


