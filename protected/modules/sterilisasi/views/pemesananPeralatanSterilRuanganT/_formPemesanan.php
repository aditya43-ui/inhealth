<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'pesanperlinensteril_tgl', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->pesanperlinensteril_tgl = !empty($model->pesanperlinensteril_tgl) ? $format->formatDateTimeForUser($model->pesanperlinensteril_tgl) : date('d M Y');
				/*$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'pesanperlinensteril_tgl',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				));*/
                echo $form->textField($model,'pesanperlinensteril_tgl', array('class'=>'span3', 'readonly'=>TRUE));
				$model->pesanperlinensteril_tgl = !empty($model->pesanperlinensteril_tgl) ? $format->formatDateTimeForDb($model->pesanperlinensteril_tgl) : date('Y-m-d');
				?>
				<?php echo $form->error($model, 'pesanperlinensteril_tgl'); ?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'pesanperlinensteril_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
	<?php 
	if ($ruangan_id == $ruangan_cssd) { 
	?>	
		<div class="control-group">
			<?php echo CHtml::label('Instalasi','Instalasi', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php /*echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
										'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
							)));*/
                    $instalasinama = Yii::app()->user->getState('instalasi_nama');
                    $instalasiId = Yii::app()->user->getState('instalasi_id');
                    echo CHtml::hiddenField('instalasi_id',$instalasiId,array('readonly'=>true,'class'=>'span3', 'value'=>$instalasinama,'onkeyup'=>"return $(this).focusNextInputField(event);"));
                    echo CHtml::TextField('instalasi_nama',$instalasinama,array('readonly'=>true,'class'=>'span3', 'value'=>$instalasinama,'onkeyup'=>"return $(this).focusNextInputField(event);"));
            ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Ruangan <span class="required">*</span>','Ruangan', array('class'=>'control-label inline')) ?>
			<div class="controls">
				<?php 
                    //echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span3 required','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); 
                    $ruanganNama = Yii::app()->user->getState('ruangan_nama');
                    $ruanganId = Yii::app()->user->getState('ruangan_id');
                    //var_dump($ruanganId);die();
                    echo CHtml::hiddenField('ruangan_id',$ruanganId,array('readonly'=>true,'class'=>'span3', 'value'=>$ruanganId,'onkeyup'=>"return $(this).focusNextInputField(event);"));
                    echo CHtml::TextField('ruangan_nama',$ruanganNama,array('readonly'=>true,'class'=>'span3', 'value'=>$ruanganNama,'onkeyup'=>"return $(this).focusNextInputField(event);"));
                    ?>
			</div>
		</div>
	<?php } ?>
            <?php echo $form->textAreaRow($model,'pesanperlinensteril_ket',array('rows'=>3,'placeholder'=>'Keterangan Pemesanan', 'cols'=>100, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'pegpemesan_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegpemesan_id',array('readonly'=>true)); ?>
                <?php // echo $form->textField($model, 'pegawaimemesan_nama', array('class' => 'span3 required','readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimemesan_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMemesan') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'pegpemesan_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
                                                'placeholder'=>'Nama Pemesan',
						'class'=>'pegawaimemesan_nama span3',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegpemesan_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMemesan'),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'pegmengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
                                                'placeholder'=>'Nama yang Mengetahui',
						'class'=>'span3 pegawaimengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Memesan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMemesan',
    'options'=>array(
        'title'=>'Pencarian Pegawai Memesan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'zIndex'=>1002,
        'resizable'=>true,
    ),
));

$modPegawaiMemesan = new STPegawaiV('searchPegawaiMemesan');
$modPegawaiMemesan->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMemesan->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimemesan-grid',
	'dataProvider'=>$modPegawaiMemesan->searchPegawaiMemesan(),
	'filter'=>$modPegawaiMemesan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegpemesan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimemesan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMemesan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMemesan, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Memesan dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>true,
    ),
));

/*$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}*/
$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                /*array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),*/
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ),
                array(
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'value' => function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => Chtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>