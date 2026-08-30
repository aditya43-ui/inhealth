

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapemeriksaan-rad-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#daftartindakan_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary(array($model,$modReferensiHasil)); ?>
        <table width='100%' class="table-condensed">
            <tr>
                <td>
                    <div class="control-group">
                    <label class="control-label" for="bidang">Daftar Tindakan</label>
                    <div class="controls">
                     <?php //echo $form->hiddenField($model,'bidang_id'); ?>
                        
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'daftartindakan_nama',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/Tindakan').'",
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
                                                        $("#'.CHtml::activeId($model, 'daftartindakan_id').'").val(ui.item.daftartindakan_id);
                                                        $("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
                                        )); 
                         ?>
                    </div>
                </div>
                    <?php echo $form->HiddenField($model,'daftartindakan_id',array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model,'jenispemeriksaanrad_id',CHtml::listData(JenispemeriksaanradM::model()->findAll(), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_nama'), array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'pemeriksaanrad_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($model,'pemeriksaanrad_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
            </tr>
        </table>
        
        <fieldset class='box'>
            <legend class='rim'>Referensi Hasil</legend>
            <?php $modReferensiHasil = new SAReferensiHasilRadM; ?>
            <table width='100%' class="table-condensed">
                <tr>
                    <td><?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                        <?php echo $form->HiddenField($modReferensiHasil,'pemeriksaanrad_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modReferensiHasil,'refhasilrad_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                        <div class="control-label">Hasil</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_hasil','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                        <td>
                            <div class="control-label">Kesimpulan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesimpulan','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                        
                        </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-label">Kesan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesan','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                        <td>
                            <div class="control-label">Keterangan</div>
                    <div class="controls">
                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_keterangan','toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                        
                        
                    </td>
                    <td>
                        
                        
                        <?php //echo $form->checkBoxRow($modReferensiHasil,'refhasilrad_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/pemeriksaanRadM/admin'), 
                                    array('class' => 'btn btn-default',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>

                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pemeriksaan Radiologi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                            $content = $this->renderPartial('../tips/tipsaddedit3a',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakanRad = new TariftindakanperdatotalV('search');
$modTindakanRad->unsetAttributes();
if(isset($_GET['TariftindakanperdatotalV']))
    $modTindakanRad->attributes = $_GET['TariftindakanperdatotalV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modTindakanRad->search(),
	'filter'=>$modTindakanRad,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            'kelompoktindakan_nama',
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            'harga_tariftindakan',
                
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'daftartindakan_id').'\").val(\'$data->daftartindakan_id\');
                                    $(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
                                    $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAPemeriksaanRadM_pemeriksaanrad_namalainnya').value = nama.value.toUpperCase();
    }
</script>

