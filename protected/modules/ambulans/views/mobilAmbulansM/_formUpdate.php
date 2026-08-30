<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'mobil-ambulans-m-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
    'focus' => '#inventarisaset',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Inventaris Aset", 'Inventaris_Aset', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'inventarisaset_id', array('id' => 'inventarisaset_id')) ?>
                <?php $barang = BarangM::model()->findByPk($model->inventarisaset_id); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'inventarisaset',
                    'value' => empty($barang) ? "" : $barang->barang_nama,
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompleteBarang') . '",
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
                        'focus' => 'js:function( event, ui )
									{
									 $(this).val(ui.item.barang_nama);
									 return false;
									 }',
                        'select' => 'js:function( event, ui ) {
									$("#alatmedis_noaset").val(ui.item.barang_id);
									$("#inventarisaset_id").val(ui.item.barang_id);
									 return false;
								 }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                        'class' => 'span4',
                        'placeholder' => 'Inventaris aset',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogbarang'),
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'mobilambulans_kode', array('readonly' => true, 'size' => 20, 'maxlength' => 20, 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'nopolisi', array('size' => 20, 'maxlength' => 20, 'class' => 'span4')); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'jeniskendaraan',
            CHtml::listData($model->JenisKendaraanItems, 'lookup_name', 'lookup_value'),
            array('class' => 'inputRequire span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
        ); ?>

        <?php echo $form->textFieldRow($model, 'isibbmliter', array('class' => 'span4 numbers-only')); ?>
        <?php echo $form->textFieldRow($model, 'kmterakhirkend', array('class' => 'span4 numbers-only')); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->FileFieldRow($model, 'photokendaraan', array('class' => 'span4', 'rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'hargabbmliter', array('class' => 'integer span4')); ?>
        <?php echo $form->textFieldRow($model, 'formulajasars', array('class' => 'span4', 'placeholder' => 'Formula jasa RS', 'size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'formulajasaba', array('class' => 'span4', 'placeholder' => 'Formula jasa BA', 'size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'formulajasapel', array('class' => 'span4', 'placeholder' => 'Formula jasa pel', 'size' => 50, 'maxlength' => 50)); ?>

        <?php // echo $form->checkBoxRow($model,'mobilambulans_aktif'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'mobilambulans_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'mobilambulans_aktif', array('checked' => 'mobilambulans_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'title' => 'Simpan',
            'id' => 'btn_simpan', 'onclick' => 'do_upload()',
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/mobilAmbulansM/admin'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Mobil Ambulans', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../mobilAmbulansM/tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogbarang',
    'options' => array(
        'title' => 'Pencarian No. Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modBarang = new AMBarangM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['AMBarangM'])) {
    $modBarang->attributes = $_GET['AMBarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
							array(
									"class"=>"btn-small",
									"id" => "selectbarang",
									"onClick" => "\$(\"#inventarisaset_id\").val($data->barang_id);
														  \$(\"#inventarisaset\").val(\"$data->barang_nama\");
														  \$(\"#dialogbarang\").dialog(\"close\");"
							 )
			 )',
        ),
        'barang_type',
        'barang_kode',
        'barang_nama',
        'barang_satuan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget(); ?>
<!--------------------------------------------------------------------- endWidget BarangM ----------------------------------------------------------------- */-->