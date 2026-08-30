<div class="row">
	<div class="col-sm-6"> 
		<div class="control-group">
			<?php echo $form->labelEx($model, 'ygmengajukan1_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'ygmengajukan1_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'ygmengajukan1_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   nama_pegawai: request.term,
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
							$("#'.Chtml::activeId($model, 'ygmengajukan1_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengajukan1 span3 required',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'ygmengjajukan1_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengajukan1'),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'ygmengjajukan2_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'ygmengjajukan2_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'ygmengajukan2_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   nama_pegawai: request.term,
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
							$("#'.Chtml::activeId($model, 'ygmengjajukan2_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengajukan2 span3 required',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'ygmengjajukan2_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengajukan2'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'ygmenyetujui1_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'ygmenyetujui1_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'ygmenyetujui1_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   nama_pegawai: request.term,
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
							$("#'.Chtml::activeId($model, 'ygmenyetujui1_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimenyetujui1 span3',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'ygmenyetujui1_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui1'),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'ygmenyetujui2_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'ygmenyetujui2_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'ygmenyetujui2_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   nama_pegawai: request.term,
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
							$("#'.Chtml::activeId($model, 'ygmenyetujui2_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimenyetujui2 span3',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'ygmenyetujui2_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui2'),
				));
				?>
			</div>
		</div>
	</div>	
</div>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengajukan1',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengajukan1 = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengajukan1->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengajukan1->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengajukan1->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMengajukan1,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'ygmengajukan1_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'ygmengajukan1_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMengajukan1\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
				'header'=>'Gelar Depan',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan1, 'gelardepan'),
				'value'=>'$data->gelardepan',
			),
			array(
				'header'=>'Nama Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan1, 'nama_pegawai'),
				'value'=>'$data->nama_pegawai',
			),
			array(
				'header'=>'Gelar Belakang',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan1, 'gelarbelakang_nama'),
				'value'=>'$data->gelarbelakang_nama',
			),
			array(
				'header'=>'Alamat Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan1, 'alamat_pegawai'),
				'value'=>'$data->alamat_pegawai',
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
    'id'=>'dialogPegawaiMengajukan2',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengajukan2 = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengajukan2->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengajukan2->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengajukan2->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMengajukan2,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'ygmengajukan2_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'ygmengajukan2_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMengajukan2\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
				'header'=>'Gelar Depan',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan2, 'gelardepan'),
				'value'=>'$data->gelardepan',
			),
			array(
				'header'=>'Nama Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan2, 'nama_pegawai'),
				'value'=>'$data->nama_pegawai',
			),
			array(
				'header'=>'Gelar Belakang',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan2, 'gelarbelakang_nama'),
				'value'=>'$data->gelarbelakang_nama',
			),
			array(
				'header'=>'Alamat Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengajukan2, 'alamat_pegawai'),
				'value'=>'$data->alamat_pegawai',
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
    'id'=>'dialogPegawaiMenyetujui1',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui1 = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMenyetujui1->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMenyetujui1->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMenyetujui1->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMenyetujui1,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'ygmenyetujui1_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'ygmenyetujui1_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMenyetujui1\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
				'header'=>'Gelar Depan',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui1, 'gelardepan'),
				'value'=>'$data->gelardepan',
			),
			array(
				'header'=>'Nama Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui1, 'nama_pegawai'),
				'value'=>'$data->nama_pegawai',
			),
			array(
				'header'=>'Gelar Belakang',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui1, 'gelarbelakang_nama'),
				'value'=>'$data->gelarbelakang_nama',
			),
			array(
				'header'=>'Alamat Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui1, 'alamat_pegawai'),
				'value'=>'$data->alamat_pegawai',
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
    'id'=>'dialogPegawaiMenyetujui2',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui2 = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMenyetujui2->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMenyetujui2->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMenyetujui2->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMenyetujui2,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'ygmenyetujui2_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'ygmenyetujui2_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMenyetujui2\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
				'header'=>'Gelar Depan',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui2, 'gelardepan'),
				'value'=>'$data->gelardepan',
			),
			array(
				'header'=>'Nama Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui2, 'nama_pegawai'),
				'value'=>'$data->nama_pegawai',
			),
			array(
				'header'=>'Gelar Belakang',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui2, 'gelarbelakang_nama'),
				'value'=>'$data->gelarbelakang_nama',
			),
			array(
				'header'=>'Alamat Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui2, 'alamat_pegawai'),
				'value'=>'$data->alamat_pegawai',
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
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'ygmengetahui_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'ygmengetahui_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
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
			),
		),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
