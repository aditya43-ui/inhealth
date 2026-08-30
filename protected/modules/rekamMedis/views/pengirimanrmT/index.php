<div class="white-container">
    <legend class="rim2">Transaksi Pengiriman <b>Dokumen Rekam Medis</b></legend>
    <?php
		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('rkpeminjamandokumenrm-v-grid', {
					data: $(this).serialize()
				});
				return false;
			});
		");
    ?>
    <?php 
    if(isset($_GET['sukses'])){
       Yii::app()->user->setFlash('success', "Data Pengiriman Dokumen Rekam Medis berhasil disimpan!");
    }
    ?>
    <div class='hide'>
        <?php 
        $warnadokrm_id = 1;
        $this->widget('ext.colorpicker.ColorPicker', 
            array(
                'name'=>'Dokumen[warnadokrm_id][]',
                'value'=>WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id),// string hexa decimal contoh 000000 atau 0000ff
                'height'=>'30px', // tinggi
                'width'=>'83px',        
                //'swatch'=>true, // default false jika ingin swatch
                'colors'=>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                'colorOptions'=>array(
                    'transparency'=> true,
                   ),
                )
            );
        ?>
    </div>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<div class="search-form">
        <?php $this->renderPartial('_searchPengiriman',array(
            'modPengiriman'=>$modPengiriman,
        )); ?>
    </div>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'rkpengirimanrm-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
		'focus'=>'#',
	)); ?>
    <div class="block-tabel">
        <h6>Tabel Pengiriman <b>Dokumen Rekam Medis</b></h6>
        <?php echo $this->renderPartial('_tabelPengiriman',array('model'=>$model,'modPengiriman'=>$modPengiriman)); ?>
    </div>
    <fieldset class="box">
        <legend class="rim">Pengiriman Dokumen Rekam Medis</legend>
        <!--<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->-->
        <?php echo $form->errorSummary($model); ?>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
					<?php echo $form->labelEx($model, 'tglpengirimanrm', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$model->tglpengirimanrm = MyFormatter::formatDateTimeForUser($model->tglpengirimanrm);
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglpengirimanrm',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
						));
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<?php // echo $form->textFieldRow($model,'petugaspengirim',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				<div class="control-group">
					<?php echo CHtml::activeLabel($model, 'petugaspengirim', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $model,
							'attribute' => 'petugaspengirim',
							'value' => '',
							'sourceUrl' => $this->createUrl('GetPetugasPengirim'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
										$(this).val(ui.item.petugaspengirim);
										return false;
									}',
								'select' => 'js:function( event, ui ) {
										$("#'.CHtml::activeId($model, 'petugaspengirim') . '").val(ui.item.nama_pegawai);
										return false; }',
							),
							'htmlOptions'=>array(
								'onkeypress'=>'return $(this).focusNextInputField(event)',
								'disabled'=>($model->isNewRecord)?'':'disabled', 
								'class'=>'span2', 
							),
							'tombolDialog'=>array('idDialog'=>'dialogPetugasPengirim'),

						));
						?>
					</div>
				</div>
			</div>
		</div>
    </fieldset>
	<div class="form-actions">
		<?php 
			if(!isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'button','onKeypress'=>'cekInputan();','onClick'=>'cekInputan();')); 
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('disabled'=>true,'class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
			}
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-default',
				'onclick'=>'return refreshForm(this);')); ?>  
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')', 'disabled'=>(empty($_GET['sukses']) ? 'disabled' : ''))); ?>
		<?php 
			$content = $this->renderPartial('../tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
	</div>
    <?php $this->endWidget(); ?>
</div>

<!--======================== Begin Widget Dialog Petugas Pengirim =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasPengirim',
    'options' => array(
        'title' => 'Petugas Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php 
$modPetugasPengirim = new RKPegawaiV('searchDialog');
$modPetugasPengirim->unsetAttributes();
if(isset($_GET['RKPegawaiV'])) {
    $modPetugasPengirim->attributes = $_GET['RKPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugaspengirim-grid',
	'dataProvider'=>$modPetugasPengirim->searchDialog(),
	'filter'=>$modPetugasPengirim,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
					"href"=>"",
					"id" => "selectPetugasPengirim",
					"onClick" => "
						$(\"#'.CHtml::activeId($model,'petugaspengirim').'\").val(\"$data->nama_pegawai\");
						$(\"#dialogPetugasPengirim\").dialog(\"close\"); 
						return false;
					"))',
		),
		array(
			'header'=>'NIP',
			'filter'=>  CHtml::activeTextField($modPetugasPengirim, 'nomorindukpegawai'),
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugasPengirim, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); ?>
<!--=============================== endWidget Dialog Petugas Pengirim ============================-->
<?php echo $this->renderPartial('_jsFunctions',array()); ?>