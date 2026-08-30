<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaan-rad-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#daftartindakan_nama',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary(array($model, $modReferensiHasil)); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label" for="bidang">Daftar Tindakan</label>
            <div class="controls">
                <?php //echo $form->hiddenField($model,'bidang_id'); 
                ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'daftartindakan_nama',
                    'value' => $model->daftartindakan->daftartindakan_nama,
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/Tindakan') . '",
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
                                                        $("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(ui.item.daftartindakan_id);
                                                        $("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                        return false;
                                                    }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3', 
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Daftar Tindakan",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->HiddenField($model, 'daftartindakan_id', CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'jenispemeriksaanrad_id', CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order' => 'jenispemeriksaanrad_nama', 'condition' => 'jenispemeriksaanrad_aktif = true')), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'subjenis_pemeriksaanrad_id', CHtml::listData(SubjenisPemeriksaanradM::model()->findAll(array('order' => 'subjenis_pr_nama', 'condition' => 'subjenis_aktif = true')), 'subjenis_pemeriksaanrad_id', 'subjenis_pr_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pemeriksaanrad_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="ROPemeriksaanRadM_pemeriksaanrad_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pemeriksaanrad_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pemeriksaanrad_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'kode_dicom_modality', array('placeholder' => 'DICOM Modality', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    </div>
</div>

<?php /*
  <fieldset class="box">
  <legend class="rim">Referensi Hasil</legend>
  <?php
  $modReferensiHasil = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id'=>$model->pemeriksaanrad_id));
  if(empty($modReferensiHasil)){
  $modReferensiHasil = new ROReferensiHasilRadM;
  }
  ?>
  <table style="width: 100%; border: none;">
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
  <!--<td>
  <div class="control-label">Kesan</div>
  <div class="controls">
  <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesan','toolbar'=>'mini','height'=>'100px')) ?>
  </div>-->
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

 *
 */ ?>

<div class="row">
    <div class="col-sm-12">
        <fieldset class="box">
            <?php echo $form->hiddenField($model, 'is_adareferensihasil', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            $refHasil = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $model->pemeriksaanrad_id));

            if (!empty($refHasil)) {
            }

            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-referensihasil',
                'content' => array(
                    'content-referensihasil' => array(
                        'header' => '<b>Referensi Hasil</b>',
                        'isi' => $this->renderPartial('_formReferensiHasil', array(
                            'form' => $form,
                            'modReferensiHasil' => $modReferensiHasil,
                            'modRefDet' => $modRefDet,
                            'model' => $model,
                            'refHasil' => $refHasil,
                        ), true),
                        'active' => (empty($refHasil) ? false : true),
                    ),
                ),
            ));
            ?>
        </fieldset>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pemeriksaanRadM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pemeriksaan Radiologi', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTindakanRad = new TariftindakanperdatotalV('search');
$modTindakanRad->unsetAttributes();
if (isset($_GET['TariftindakanperdatotalV']))
    $modTindakanRad->attributes = $_GET['TariftindakanperdatotalV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modTindakanRad->search(),
    'filter' => $modTindakanRad,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                            "#",
                            array(
                                "class"=>"btn-small",
                                "id" => "selectTindakan",
                                "onClick" => "
                                $(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
                                $(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
                                $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
        ),
        array(
            'header' => 'Kategori Tindakan',
            'name' => 'kategoritindakan_id',
            'type' => 'raw',
            'value' => '$data->kategoritindakan_nama',
            'filter' => CHtml::activeDropDownList(
                $modTindakanRad,
                'kategoritindakan_id',
                CHtml::listData(
                    KategoritindakanM::model()->findAll(array(
                        'condition' => 'kategoritindakan_aktif = true',
                        'order' => 'kategoritindakan_nama'
                    )),
                    'kategoritindakan_id',
                    'kategoritindakan_nama'
                ),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Kelompok Tindakan',
            'name' => 'kelompoktindakan_id',
            'type' => 'raw',
            'value' => '$data->kelompoktindakan_nama',
            'filter' => CHtml::activeDropDownList(
                $modTindakanRad,
                'kelompoktindakan_id',
                CHtml::listData(
                    KelompoktindakanM::model()->findAll(array(
                        'condition' => 'kelompoktindakan_aktif = true',
                        'order' => 'kelompoktindakan_nama'
                    )),
                    'kelompoktindakan_id',
                    'kelompoktindakan_nama'
                ),
                array('empty' => '-- Pilih --')
            ),
        ),
        'daftartindakan_kode',
        'daftartindakan_nama',
        'harga_tariftindakan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('modRefDet' => $modRefDet, 'modReferensiHasil' => $modReferensiHasil)); ?>
<script type="text/javascript">

    $("#form-referensihasil .accordion-toggle").click(function() {
        if ($(this).hasClass('collapsed')) {
            $("#<?php echo CHtml::activeId($model, 'is_adareferensihasil'); ?>").val(0);
        } else {
            $("#<?php echo CHtml::activeId($model, 'is_adareferensihasil'); ?>").val(1);
        }
    });

    function namaLain(nama) {
        document.getElementById('ROPemeriksaanRadM_pemeriksaanrad_namalainnya').value = nama.value.toUpperCase();
    }
</script>