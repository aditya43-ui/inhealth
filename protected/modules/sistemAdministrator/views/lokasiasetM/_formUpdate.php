
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'salokasiaset-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'lokasiaset_kode'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

             <?php // Echo CHtml::hiddenField('tempKode', $model->lokasiaset_kode); ?>
            <?php echo $form->textFieldRow($model,'lokasiaset_kode',array('class'=>'span3 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,)); ?>
            <div class="control-group">
                    <label class="control-label" for="instalasi">Instalasi Lokasi Aset</label>
                    <div class="controls">
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'lokasiaset_namainstalasi',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getInstalasi').'",
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
                                                        $("#'.CHtml::activeId($model, 'lokasiaset_namainstalasi').'").val(ui.item.instalasi_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
													'class'=>'angkahuruf-only',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogInstalasi'),
                                        )); 
                        ?>
                    </div>
                </div>
            <div class="control-group">
                    <label class="control-label" for="ruangan">Ruangan Lokasi Aset</label>
                    <div class="controls">
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'lokasiaset_namabagian',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getRuangan').'",
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
                                                        $("#'.CHtml::activeId($model, 'lokasiaset_namabagian').'").val(ui.item.ruangan_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
													'class'=>'angkahuruf-only',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogRuangan'),
                                        )); 
                        ?>
                    </div>
                </div>
            <?php //echo $form->textFieldRow($model,'lokasiaset_namainstalasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php //echo $form->textFieldRow($model,'lokasiaset_namabagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'lokasiaset_namalokasi',array('class'=>'span3 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->checkBoxRow($model,'lokasiaset_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                               <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                       '', 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php //$this->widget('UserTips',array('type'=>'create'));?>
        <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Lokasi Aset', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
$content = $this->renderPartial($this->path_view.'tips.tipsCreate',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data instalasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogInstalasi',
    'options'=>array(
        'title'=>'Instalasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modinstalasi = new SAInstalasiM('search');
$modinstalasi->unsetAttributes();
if(isset($_GET['SAInstalasiM']))
    $moObatAlkes->attributes = $_GET['SAInstalasiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modinstalasi->search(),
	'filter'=>$modinstalasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectInstalasi",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namainstalasi').'\").val(\'$data->instalasi_nama\');
                                    $(\'#dialogInstalasi\').dialog(\'close\');return false;"))',
                ),
                'instalasi_nama',
		'instalasi_singkatan',
                'instalasi_lokasi',
                
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
        
<?php
//========= Dialog buat cari data ruangan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Ruangan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modRuangan = new SARuanganM('search');
$modRuangan->unsetAttributes();
if(isset($_GET['SARuanganM']))
    $moObatAlkes->attributes = $_GET['SARuanganM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saruangan-m-grid',
	'dataProvider'=>$modRuangan->search(),
	'filter'=>$modRuangan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'ruangan_nama',
		'ruangan_jenispelayanan',
                'ruangan_lokasi',
                
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRuangan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namabagian').'\").val(\'$data->ruangan_nama\');
                                    $(\'#dialogRuangan\').dialog(\'close\');return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php 
Yii::app()->clientScript->registerScript('head','
    function setKode(obj){
        var value = $("#tempKode").val();
        var objValue = $(obj).val();
        if (objValue < value){
           $(obj).val(value);
        }
    }
',  CClientScript::POS_HEAD); ?>
<?php 

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>