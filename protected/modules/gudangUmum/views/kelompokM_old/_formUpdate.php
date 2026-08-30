<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakelompok-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'golongan_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<!--<div class="control-group">
                    <label class="control-label" for="bidang">Golongan</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'golongan_id'); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(

                        'name' => 'golonganNama',
                        'value' => $model->golongan_nama,
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/getGolongan') . '",
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
                                                        $("#' . CHtml::activeId($model, 'golongan_id') . '").val(ui.item.golongan_id);
                                                        $("#golonganNama").val(ui.item.golongan_nama);
                                                        return false;
                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogGolongan'),
                    ));
                    ?>
                    </div>
                </div>-->

<?php echo $form->dropDownListRow($model, 'golongan_id',  CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
<?php echo $form->textFieldRow($model, 'kelompok_kode', array('class' => 'span1 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); ?>
<?php echo $form->textFieldRow($model, 'kelompok_nama', array('class' => 'span2', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($model, 'kelompok_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<div>
    <?php echo $form->checkBoxRow($model, 'kelompok_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kelompokM/admin'),
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
        Yii::t('mds', '{icon} Pengaturan Kelompok', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/kelompokM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
// $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//     'id'=>'dialogGolongan',
//     'options'=>array(
//         'title'=>'Golongan',
//         'autoOpen'=>false,
//         'modal'=>true,
//         'width'=>750,
//         'height'=>600,
//         'resizable'=>false,
//     ),
// ));

// $modGolongan = new GUKelompokM('search');
// $modGolongan->unsetAttributes();
// if(isset($_GET['GUKelompokM']))
//     $modGolongan->attributes = $_GET['GUKelompokM'];

// $this->widget('ext.bootstrap.widgets.BootGridView',array(
// 	'id'=>'sainstalasi-m-grid',
// 	'dataProvider'=>$modGolongan->search(),
// 	'filter'=>$modGolongan,
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
//                                     "id" => "selectGolongan",
//                                     "onClick" => "
//                                     $(\"#'.CHtml::activeId($model, 'golongan_id').'\").val($data->golongan_id);
//                                     $(\"#golonganNama\").val(\'$data->golonganNama\');
//                                     $(\'#dialogGolongan\').dialog(\'close\');return false;"))'
//                 ),
//                 array(
//                         'header'=>'Golongan',
//                         'filter'=>  CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
//                         'value'=>'$data->golongan->golongan_nama',
//                 ),
//                 array(
//                         'header'=>'Kelompok',
//                         'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
//                         'value'=>'$data->kelompok_nama',
//                 ),
//                 array(
//                         'header'=>'Sub Kelompok',
// //                        'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
//                         'type'=>'raw',

//                         'value'=>'$this->grid->getOwner()->renderPartial(\'listSubKelompok\', array(\'idKelompok\'=>$data->kelompok_id))',
//                 ),
// //                array(
// //                        'header'=>'bidang_id',
// //                        'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
// //                        'type'=>'raw',
// //                        'value'=>'$this->grid->getOwner->renderPartial(\'listBidang\',array(\'idKelompok\'=>\'$data->kelompok_id\'))',
// //                ),


// 	),
//         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
// )); 

// $this->endWidget();
?>
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

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKelompokM_kelompok_namalainnya').value = nama.value.toUpperCase();
    }
</script>