<style>
    .hiddenInputan {
    display: none !important;
    visibility: hidden;
}
</style>
<div class="row-fluid">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'jenisstokopnamegizi', array('readonly'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));?>
		<?php echo $form->textFieldRow($model, 'nostokopnamegizi', array('class' => 'span3 ', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>

    <div class="control-group ">
        <?php echo $form->labelEx($model, 'tglstokopnamegizi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
                $model->tglstokopnamegizi = (!empty($model->tglstokopnamegizi) ? MyFormatter::formatDateTimeForUser($model->tglstokopnamegizi) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tglstokopnamegizi',
                    'mode'=>'datetime',
                    'options'=> array(
			                   'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
      </div>
      <div class="control-group ">
  			<?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
  			<div class="controls">
  				<?php echo $form->hiddenField($model, 'mengetahui_id'); ?>
  				<?php
  				$this->widget('MyJuiAutoComplete', array(
  					'model'=>$model,
  					'attribute' => 'mengetahui_nama',
  					'source' => 'js: function(request, response) {
  									   $.ajax({
  										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
  							$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);
  							return false;
  						}',
  					),
  					'htmlOptions' => array(
  						'placeholder'=>'Ketikan Pegawai Mengetahui',
  						'class'=>'mengetahui_nama span3',
  						'onkeyup'=>"return $(this).focusNextInputField(event)",
  						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
  					),
  					'tombolDialog' => array('idDialog' => 'dialogMengetahui'),
  				));
  				?>
  			</div>
  		</div>
      <div class="control-group ">
  			<?php echo $form->labelEx($model, 'petugas1_id', array('class' => 'control-label')); ?>
  			<div class="controls">
  				<?php echo $form->hiddenField($model, 'petugas1_id'); ?>
  				<?php
  				$this->widget('MyJuiAutoComplete', array(
  					'model'=>$model,
  					'attribute' => 'petugas1_nama',
  					'source' => 'js: function(request, response) {
  									   $.ajax({
  										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
  							$("#'.Chtml::activeId($model, 'petugas1_id') . '").val(ui.item.pegawai_id);
  							return false;
  						}',
  					),
  					'htmlOptions' => array(
  						'placeholder'=>'Ketikan Petugas 1',
  						'class'=>'petugas1_nama span3',
  						'onkeyup'=>"return $(this).focusNextInputField(event)",
  						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugas1_id') . '").val(""); '
  					),
  					'tombolDialog' => array('idDialog' => 'dialogPetugas1'),
  				));
  				?>
  			</div>
  		</div>
      <div class="control-group ">
  			<?php echo $form->labelEx($model, 'petugas2_id', array('class' => 'control-label')); ?>
  			<div class="controls">
  				<?php echo $form->hiddenField($model, 'petugas2_id'); ?>
  				<?php
  				$this->widget('MyJuiAutoComplete', array(
  					'model'=>$model,
  					'attribute' => 'petugas2_nama',
  					'source' => 'js: function(request, response) {
  									   $.ajax({
  										   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
  							$("#'.Chtml::activeId($model, 'petugas2_id') . '").val(ui.item.pegawai_id);
  							return false;
  						}',
  					),
  					'htmlOptions' => array(
  						'placeholder'=>'Ketikan Petugas 2',
  						'class'=>'petugas2_nama span3',
  						'onkeyup'=>"return $(this).focusNextInputField(event)",
  						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugas2_id') . '").val(""); '
  					),
  					'tombolDialog' => array('idDialog' => 'dialogPetugas2'),
  				));
  				?>
  			</div>
  		</div>
	</div>
	<div class="col-sm-6">
    <div class="control-group ">
      <?php echo CHtml::label('Total Nilai Persediaan', '', array('class' => 'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model,'totalharga',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
      </div>
    </div>
    <div class="control-group ">
      <?php echo CHtml::label('Total Netto', '', array('class' => 'control-label')); ?>
      <div class="controls">
        <?php echo $form->textField($model,'totalnetto',array('class'=>'span3 integer-decimal','readonly'=>true)); ?>
      </div>
    </div>
    <?php echo $form->textAreaRow($model,'keterangan_opname',array('class'=>'span3')); ?>
	</div>
</div>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
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
										  $(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'mengetahui_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogMengetahui\").dialog(\"close\");
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		),
		array(
			'header'=>'Jabatan',
			'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(
                        JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), array(
                            'empty'=>'-- Pilih --',
                        )),
            'value'=>function($data) {
                if (empty($data->jabatan_id)) return "-";
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                return $j->jabatan_nama;
            }
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
    'id'=>'dialogPetugas1',
    'options'=>array(
        'title'=>'Pencarian Petugas 1',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas1 = new PegawairuanganV('search');
$modPetugas1->unsetAttributes();
$modPetugas1->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPetugas1->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai1-grid',
    'dataProvider'=>$modPetugas1->search(),
    'filter'=>$modPetugas1,
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
										  $(\"#'.CHtml::activeId($model,'petugas1_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'petugas1_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas1\").dialog(\"close\");
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		),
		array(
			'header'=>'Jabatan',
			'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(
                        JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), array(
                            'empty'=>'-- Pilih --',
                        )),
            'value'=>function($data) {
                if (empty($data->jabatan_id)) return "-";
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                return $j->jabatan_nama;
            }// '$data->alamat_pegawai',
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
    'id'=>'dialogPetugas2',
    'options'=>array(
        'title'=>'Pencarian Petugas 2',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas2 = new PegawairuanganV('search');
$modPetugas2->unsetAttributes();
$modPetugas2->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPetugas2->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai2-grid',
    'dataProvider'=>$modPetugas2->search(),
    'filter'=>$modPetugas2,
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
										  $(\"#'.CHtml::activeId($model,'petugas2_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($model,'petugas2_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas2\").dialog(\"close\");
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
                        'name'=>'nomorindukpegawai',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		),
		array(
			'header'=>'Jabatan',
			'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(
                        JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'), array(
                            'empty'=>'-- Pilih --',
                        )),
            'value'=>function($data) {
                if (empty($data->jabatan_id)) return "-";
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                return $j->jabatan_nama;
            }// '$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
