<div class = "col-sm-6">
    <?php echo CHtml::hiddenField('rencanakebfarmasi_id',$modRencanaKebFarmasi->rencanakebfarmasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3 isRequired', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modRencanaKebFarmasi->tglperencanaan = (!empty($modRencanaKebFarmasi->tglperencanaan) ? date("d/m/Y H:i:s",strtotime($modRencanaKebFarmasi->tglperencanaan)) : null);
                        echo $form->textField($modRencanaKebFarmasi, 'tglperencanaan', array('class' => 'span3 realtime','readonly'=>true));
						/* $this->widget('MyDateTimePicker',array(
                            'model'=>$modRencanaKebFarmasi,
                            'attribute'=>'tglperencanaan',
                            'mode'=>'datetime',
                            'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); */ ?>
                </div>
        </div>
    <?php echo $form->dropDownListRow($modRencanaKebFarmasi,'sumberdana_id',
		CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'),
		array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
		'empty'=>'-- Pilih --')); ?>  
    <div class="control-group ">
        <?php echo CHtml::label('Waktu Pemakaian Obat', '', array('class'=>'control-label')); ?>
        <div class="controls">
			<?php echo CHtml::hiddenField('o','',array()); ?>
			<?php echo CHtml::hiddenField('x','',array()); ?>
			<?php echo CHtml::hiddenField('sd','',array()); ?>
			<?php echo CHtml::hiddenField('soh','',array()); ?>
			<?php echo CHtml::hiddenField('k','',array()); ?>
			<?php echo CHtml::hiddenField('lt','',array()); ?>
			<?php echo CHtml::hiddenField('buffer_stok','',array()); ?>
			<?php echo CHtml::activeHiddenField($modRencanaKebFarmasi, 'leadtime_lt', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?>
			<?php echo CHtml::activeTextField($modRencanaKebFarmasi, 'jmlwaktupemakaian', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?> bulan
			<?php //echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i> Hitung RO',
				//array('onclick'=>'hitungRO();return false;',
				//	'class'=>'btn btn-primary',
				//	'onkeyup'=>"hitungRO();",
				//	'rel'=>"tooltip",
				//	'title'=>"Klik untuk menghitung Recomended Order (RO)",)); ?>
        </div>
    </div>
    
</div>
<div class = "col-sm-6">
    <?php echo $form->textAreaRow($modRencanaKebFarmasi,'keterangan_rencana',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
    <div class="control-group ">
		<?php echo $form->labelEx($modRencanaKebFarmasi, 'pegawai_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($modRencanaKebFarmasi, 'pegawai_id',array('readonly'=>true)); ?>
			<?php echo $form->textField($modRencanaKebFarmasi, 'nama_pegawai',array('readonly'=>true, 'class' => 'required')); ?>
                        <?php
//				$this->widget('MyJuiAutoComplete', array(
//				'model'=>$modRencanaKebFarmasi,
//				'attribute' => 'nama_pegawai',
//				'source' => 'js: function(request, response) {
//					$.ajax({
//						url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
//						dataType: "json",
//						data: {
//							term: request.term,
//						},
//						success: function (data) {
//							response(data);
//						}
//					})
//				}',
//				'options' => array(
//					'showAnim' => 'fold',
//					'minLength' => 3,
//					'focus' => 'js:function( event, ui ) {
//						$(this).val( ui.item.label);
//						return false;
//					}',
//					'select' => 'js:function( event, ui ) {
//						$("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawai_id') . '").val(ui.item.pegawai_id); 
//						return false;
//					}',
//				),
//				'htmlOptions' => array(
//					'class'=>'pegawai_nama',
//					'onkeyup'=>"return $(this).focusNextInputField(event)",
//					'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawai_id') . '").val(""); '
//				),
//				'tombolDialog' => array('idDialog' => 'dialogPegawaiGudang'),
//			));
			?>
		</div>
    </div>
    <div class="control-group " style="display: none;">
		<?php // echo $form->labelEx($modRencanaKebFarmasi, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php // echo $form->hiddenField($modRencanaKebFarmasi, 'pegawaimengetahui_id',array('readonly'=>true)); ?>
			<?php
//				$this->widget('MyJuiAutoComplete', array(
//					'model'=>$modRencanaKebFarmasi,
//					'attribute' => 'pegawaimengetahui_nama',
//					'source' => 'js: function(request, response) {
//						$.ajax({
//							url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
//							dataType: "json",
//							data: {
//								term: request.term,
//							},
//							success: function (data) {
//								response(data);
//							}
//						})
//					}',
//					'options' => array(
//						'showAnim' => 'fold',
//						'minLength' => 3,
//						'focus' => 'js:function( event, ui ) {
//							$(this).val( ui.item.label);
//							return false;
//						}',
//						'select' => 'js:function( event, ui ) {
//							$("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
//							return false;
//						}',
//					),
//					'htmlOptions' => array(
//						'class'=>'pegawaimengetahui_nama',
//						'onkeyup'=>"return $(this).focusNextInputField(event)",
//						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawaimengetahui_id') . '").val(""); '
//					),
//					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
//				));
			?>
		</div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label('Kepala Instalasi Farmasi <span class="required">*</span>','' , array('class' => 'control-label required')); ?>
		<?php // echo $form->labelEx($modRencanaKebFarmasi, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($modRencanaKebFarmasi, 'pegawaimenyetujui_id',array('readonly'=>true)); ?>
                            <?php echo $form->textField($modRencanaKebFarmasi, 'pegawaimenyetujui_nama',array('readonly'=>true, 'class' => 'required')); ?>
                            <?php
//				$this->widget('MyJuiAutoComplete', array(
//					'model'=>$modRencanaKebFarmasi,
//					'attribute' => 'pegawaimenyetujui_nama',
//					'source' => 'js: function(request, response) {
//						$.ajax({
//							url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
//							dataType: "json",
//							data: {
//								term: request.term,
//							},
//							success: function (data) {
//								response(data);
//							}
//						})
//					}',
//					'options' => array(
//						'showAnim' => 'fold',
//						'minLength' => 3,
//						'focus' => 'js:function( event, ui ) {
//							$(this).val( ui.item.label);
//							return false;
//						}',
//						'select' => 'js:function( event, ui ) {
//							$("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
//							return false;
//						}',
//					),
//					'htmlOptions' => array(
//						'class'=>'pegawaimenyetujui_nama',
//						'onkeyup'=>"return $(this).focusNextInputField(event)",
//						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebFarmasi, 'pegawaimenyetujui_id') . '").val(""); '
//					),
//					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
//				));
			?>
		</div>
    </div>    
</div>
<!--<div class = "span5">
    <div class="control-group ">
        <?php // echo $form->labelEx($modRencanaKebFarmasi,'statusrencana', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($modRencanaKebFarmasi,'statusrencana',LookupM::getItems('statusrencana'),array('empty'=>'--Pilih--','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>
</div>-->

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiGudang',
    'options'=>array(
        'title'=>'Pencarian Pegawai Gudang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiGudang = new ADPegawaiV('search');
$modPegawaiGudang->unsetAttributes();
if(isset($_GET['ADPegawaiV'])) {
    $modPegawaiGudang->attributes = $_GET['ADPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaigudang-grid',
	'dataProvider'=>$modPegawaiGudang->search(),
	'filter'=>$modPegawaiGudang,
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
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'nama_pegawai').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiGudang\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
                array(
                    'header'=>'Jabatan',
					'name'=>'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiGudang, 'jabatan_id', CHtml::listData(
					JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
					),
					array('empty'=>'-- Pilih --')),
                    'value'=>function($data) {
						if (empty($data->jabatan_id)) return "-";
						$jabatan = JabatanM::model()->findByPk($data->jabatan_id);
						return $jabatan->jabatan_nama;
					},
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('search');
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
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
                array(
                    'header'=>'Jabatan',
					'name'=>'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(
					JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
					),
					array('empty'=>'-- Pilih --')),
                    'value'=>function($data) {
						if (empty($data->jabatan_id)) return "-";
						$jabatan = JabatanM::model()->findByPk($data->jabatan_id);
						return $jabatan->jabatan_nama;
					},
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new ADPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['ADPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['ADPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
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
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiGudang, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
                array(
                    'header'=>'Jabatan',
					'name'=>'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', CHtml::listData(
					JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
					),
					array('empty'=>'-- Pilih --')),
                    'value'=>function($data) {
						if (empty($data->jabatan_id)) return "-";
						$jabatan = JabatanM::model()->findByPk($data->jabatan_id);
						return $jabatan->jabatan_nama;
					},
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>