<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rmtindakanrm-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenistindakanrm_id', CHtml::listData($model->getJenisTindakanItems(), 'jenistindakanrm_id', 'jenistindakanrm_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <div class="control-group">
            <?php echo $form->label($model, 'daftartindakan_id', array('class' => 'control-label')); ?>
            <?php echo CHtml::ActiveHiddenField($model, 'daftartindakan_id', array('readonly' => true)) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'daftartindakan_nama',
                    'sourceUrl' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteDaftarTindakan') . '",
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
											$("#RMTindakanrmM_daftartindakan_id").val(ui.item.daftartindakan_id);
											$(this).val(ui.item.label);
											return false;
										}',
                    ),
                    'htmlOptions' => array(
                        'value' => '', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'placeholder' => 'Daftar Tindakan',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDaftarTindakan'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'tindakanrm_nama', array('placeholder' => 'Uraian Tindakan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'tindakanrm_namalainnya', array('placeholder' => 'Nama Lain Tindakan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/tindakanRM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Tindakan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('tindakanRM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'update', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data daftar tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakan',
    'options' => array(
        'title' => 'Pencarian Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modTarifTindakan = new RMTarifTindakanM('searchDaftarTindakan');
$modTarifTindakan->unsetAttributes();
if (isset($_GET['RMTarifTindakanM'])) {
    $modTarifTindakan->attributes = $_GET['RMTarifTindakanM'];
    $modTarifTindakan->daftartindakan_nama = isset($_GET['RMTarifTindakanM']['daftartindakan_nama']) ? $_GET['RMTarifTindakanM']['daftartindakan_nama'] : null;
    $modTarifTindakan->kelaspelayanan_id = isset($_GET['RMTarifTindakanM']['kelaspelayanan_id']) ? $_GET['RMTarifTindakanM']['kelaspelayanan_id'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'satarif-tindakan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTarifTindakan->searchDaftarTindakan(),
    'filter' => $modTarifTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectDaftarTindakan",
					"onClick" => "$(\"#RMTindakanrmM_daftartindakan_id\").val(\"$data->daftartindakan_id\");
								  $(\"#RMTindakanrmM_daftartindakan_nama\").val(\"".$data->daftartindakan->daftartindakan_nama." - ".$data->kelaspelayanan->kelaspelayanan_nama." - ".$data->harga_tariftindakan."\");
								  $(\"#dialogDaftarTindakan\").dialog(\"close\");    
					"))',
        ),
        array(
            'header' => 'Daftar Tindakan',
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan->daftartindakan_nama',
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'name' => 'kelaspelayanan_id',
            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
            'filter' => CHtml::listData($modTarifTindakan->KelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
        ),
        array(
            'header' => 'Nominal Tarif',
            'name' => 'harga_tariftindakan',
            'value' => 'number_format($data->harga_tariftindakan,0,".",",")',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end daftar tindakan dialog =============================
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('RMTindakanrmM_tindakanrm_namalainnya').value = nama.value.toUpperCase();
    }
</script>