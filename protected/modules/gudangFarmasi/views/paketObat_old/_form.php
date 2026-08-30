<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);


$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfpabrik-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'pabrik_kode'),
)); ?>
<div class="row-fluid">
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
    <div class="row col-sm-12">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo CHtml::label('Dokter','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
                        echo Chtml::activeHiddenField($model,'dokter_id',array());
                        $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute'=>'nama_pegawai',
                                        'source'=>'js: function(request, response) {
                                                $.ajax({
                                                        url: "'.$this->createUrl('/actionAutoComplete/ListDokter').'",
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
                                                'minLength' => 2,
                                                'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( "");
                                                        return false;
                                                }',
                                                'select'=>'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        $("#GFPaketobatM_dokter_id").val(ui.item.value);
                                                        return false;
                                                }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                        'htmlOptions'=>array('placeholder'=>'Ketik Nama Dokter','class'=>'span3 all-caps pegawaishift_nama','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data pegawai',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",       
                                            'onblur' => 'if(this.value === "") $("#GFPaketobatM_dokter_id").val(""); '
                                        ),
                                )); 
                        ?>
                </div>
            </div> 
            <?php echo $form->textFieldRow($model,'nama_paket',array('class'=>'span3 required','maxlength'=>100)); ?>            
            <div class='control-group'>
                <?php echo CHtml::label("",'is_paketbmhp', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::label(CHtml::activeCheckBox($model, 'is_paketbmhp')."Paket BMHP",'is_paketbmhp', array('class' => 'control-label'))?>
                </div>
            </div> 
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'harga_paket',array('class'=>'span3 required','maxlength'=>100)); ?>            
            <div class='control-group'>
                <?php echo CHtml::label("",'is_aktif', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'is_aktif',array('checked'=>'is_aktif', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
                </div>
            </div> 
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Daftar Obat</div>
                </div>
                <?php $this->renderPartial($this->path_view.'_formObat', array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail)); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			$this->createUrl('create'), 
			array('class'=>'btn btn-danger',
			'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Master Paket Obat',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php
			$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
			$this->widget('UserTips',array('type'=>'master','content'=>$content));
		?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array()); ?>

<?php
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 550,
        'resizable' => false,
    ),
));
$modPegawai = new DokterV('searchByDokter');
$modPegawai->unsetAttributes();
if(isset($_GET['DokterV'])){
    $modPegawai->attributes = $_GET['DokterV'];
    $modPegawai->jabatan_nama = isset($_GET['DokterV']['jabatan_nama'])?$_GET['DokterV']['jabatan_nama']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->searchAllDokter(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#GFPaketobatM_dokter_id\").val(\"$data->pegawai_id\");
                            $(\"#GFPaketobatM_nama_pegawai\").val(\"$data->nama_pegawai\");
                            $(\"#GFPaketobatM_jabatan_nama\").val(\"$data->jabatan_nama\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap'
        ),        
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama',
            'value' => '$data->jabatan_nama'
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>