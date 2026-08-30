<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabidang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'subkelompok_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<!--<div class="control-group">
                    <label class="control-label" for="bidang">Sub Kelompok</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'subkelompok_id'); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(

                        'name' => 'subkelompokNama',
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/getSubKelompok') . '",
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
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                            'select' => 'js:function( event, ui ) { 
                                                        $("#' . CHtml::activeId($model, 'subkelompok_id') . '").val(ui.item.subkelompok_id);
                                                        $("#subkelompokNama").val(ui.item.subkelompok_nama);
                                                        return false;
                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSubKelompok'),
                    ));
                    ?>
                    </div>
                </div>-->
<?php //Echo CHtml::hiddenField('tempKode', $model->bidang_kode); 
?>
<?php echo $form->dropDownListRow($model, 'subkelompok_id', CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
<?php echo $form->textFieldRow($model, 'bidang_kode', array('class' => 'span1 ', 'onkeyup' => 'setKode(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); ?>
<?php echo $form->textFieldRow($model, 'bidang_nama', array('class' => 'span2', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'bidang_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php //echo $form->checkBoxRow($model,'bidang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bidangM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangUmum.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bidang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/bidangM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>
<?php
//Yii::app()->clientScript->registerScript('head','
//    function setKode(obj){
//        var value = $("#tempKode").val();
//        var objValue = $(obj).val();
//        if (objValue < value){
//           $(obj).val(value);
//        }
//    }
//',  CClientScript::POS_HEAD); 
?>

<?php
//========= Dialog buat cari data Bidang =========================
// $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//     'id'=>'dialogSubKelompok',
//     'options'=>array(
//         'title'=>'Sub Kelompok',
//         'autoOpen'=>false,
//         'modal'=>true,
//         'width'=>750,
//         'height'=>600,
//         'resizable'=>false,
//     ),
// ));

// $modsubKelompok= new GUSubkelompokM('search');
// $modsubKelompok->unsetAttributes();
// if(isset($_GET['GUSubkelompokM']))
//     $modsubKelompok->attributes = $_GET['GUSubkelompokM'];

// $this->widget('ext.bootstrap.widgets.BootGridView',array(
// 	'id'=>'sainstalasi-m-grid',
// 	'dataProvider'=>$modsubKelompok->search(),
// 	'filter'=>$modsubKelompok,
//         'template'=>"{summary}\n{items}\n{pager}",
//         'itemsCssClass'=>'table table-striped table-bordered table-condensed',
// 	'columns'=>array(
//                 array(
//                     'header'=>'Pilih',
//                     'type'=>'raw',
//                     'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
//                                 "#",
//                                 array(
//                                     "class"=>"btn-small", 
//                                     "id" => "selectKelompok",
//                                     "onClick" => "
//                                     $(\"#'.CHtml::activeId($model, 'subkelompok_id').'\").val($data->subkelompok_id);
//                                     $(\"#subkelompokNama\").val(\'$data->subkelompok_nama\');
//                                     $(\'#dialogSubKelompok\').dialog(\'close\');return false;"))'
//                 ),
//                 array(
//                       'header'=>'Sub Kelompok',
//                      'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
//                       'type'=>'raw',

//                       'value'=>'$data->subkelompok_nama',
//                 ),
//                 array(
//                         'header'=>'Kelompok ',
//                         'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
//                         'value'=>'$data->kelompok->kelompok_nama',
//                 ),
// 	),
//         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
// )); 

// $this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SABidangM_bidang_namalainnya').value = nama.value.toUpperCase();
    }
</script>