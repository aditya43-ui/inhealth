<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id',array('readonly'=>true, 'class'=>'span1')); ?>
            <?php echo CHtml::activeLabel($model, 'pasienblacklist_karenakasus', array('class' => 'control-label')); ?>
            <div class="controls">
                    <?php echo $form->textField($model, 'pasienblacklist_karenakasus', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('required'=>true,'readonly' => true, 'id' => 'pegawai_id')) ?>
                    <?php
                    $modul = ModulK::model()->findByAttributes(
                                    array('modul_key' => $this->module->id)
                    );
                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                    $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nama_pegawai',
                            'value' => isset($model->pegawai->nama_pegawai) ? $model->pegawai->nama_pegawai : "",
                            'sourceUrl' => $this->createUrl('AutocompletePegawai'),
                            'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                                $("#pegawai_id").val( ui.item.value );
                                $("#nama_pegawai").val( ui.item.nama_pegawai );
                                return false;
                            }',
                                    'select' => 'js:function( event, ui ) {
                                $("#pegawai_id").val( ui.item.value );
                                return false;
                            }',
                            ),
                            'htmlOptions' => array('required'=>true,'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                    ));
                    ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'pasienblacklist_ket', array('class' => 'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textArea($model, 'pasienblacklist_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPegawai',
	'options' => array(
		'title' => 'Daftar Pegawai',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 500,
		'resizable' => false,
	),
));

$modPegawai = new RKPegawaiM;
if (isset($_GET['RKPegawaiM'])){
	$modPegawai->attributes = $_GET['RKPegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pegawai-m-grid',
	'dataProvider' => $modPegawai->searchDialog(),
	'filter' => $modPegawai,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
								$(\"#pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawai\").dialog(\"close\");    
                                return false;
                                "))',
		),
		'nomorindukpegawai',
		'nama_pegawai',
		'tempatlahir_pegawai',
		'jeniskelamin',
		'statusperkawinan',
		array(
			'header' => 'Jabatan',
			'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
		),
		'alamat_pegawai',
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>