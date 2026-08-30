<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kesejahteraanibu-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
    
    <?php echo $form->hiddenField($model,'partografpasien_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="row-fluid">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'pemeriksaanke', array('class' => 'span1 numbers-only', 'readonly' => true)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgl_pemeriksaan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jam_pemeriksaan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_pemeriksaan',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'petugaspemeriksa_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'petugaspemeriksa_id', array('class' => 'petugaspemeriksa_id')); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'petugaspemeriksa_nama',
                            'value' => empty($model->petugaspemeriksa) ? "" : $model->petugaspemeriksa->namaLengkap,
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('autocompletePegawaiPemeriksa') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val("");
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        $(".petugaspemeriksa_id").val(ui.item.pegawai_id);
                                        $(".petugaspemeriksa_nama").val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'petugaspemeriksa_nama span3',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugasKesejahteraanIbu'),
                        ));
                        ?>
                    </div>
                </div>
                <hr/>
                <?php echo $this->renderPartial($this->path_view."form._nadi", array(
                    'form'=>$form, 'model'=>$model,
                ), true); ?>
                <hr/>
                <?php echo $this->renderPartial($this->path_view."form._suhu", array(
                    'form'=>$form, 'model'=>$model,
                ), true); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $this->renderPartial($this->path_view."form._oksitosin", array(
                    'form'=>$form, 'model'=>$model,
                ), true); ?>
                <hr/>
                <?php echo $this->renderPartial($this->path_view."form._urine", array(
                    'form'=>$form, 'model'=>$model,
                ), true); ?>
                
            </div>
        </div>
	</div>
    <div class="row-fluid">
        <?php echo $this->renderPartial($this->path_view."form._obat", array(
            'form'=>$form, 'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id,
        ), true); ?>
    </div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan KesejahteraanibuT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

    
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasKesejahteraanIbu',
    'options' => array(
        'title' => 'Petugas Pemeriksa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
$petugas = new PegawairuanganV('search');
$petugas->unsetAttributes();
$petugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $petugas->attributes = $_GET['PegawairuanganV'];
    //$petugas->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $petugas->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
//    $petugas->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jantung-pemeriksa-grid',
    'dataProvider' => $petugas->searchPegawaiRuangan(),
    'filter' => $petugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'.petugaspemeriksa_id\').val($data->pegawai_id);
                                        $(\'.petugaspemeriksa_nama\').val(\'$data->namaLengkap\');
                                        $(\'#dialogPetugasKesejahteraanIbu\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

    
    <script>
        
        function cekInputPanel() {
            $(".form_pilih").each(function() {
                if ($(this).find(".form_pilih_ceklis").is(":checked")) {
                    $(this).find(".form_pilih_content input[type=text]").attr("disabled", false);
                } else {
                    $(this).find(".form_pilih_content input[type=text]").attr("disabled", true).val("");
                }
            });
        }
        
        $(document).ready(function() {
            $(".form_pilih .form_pilih_ceklis").on('click', cekInputPanel);
            cekInputPanel();
        });
        
        
    </script>