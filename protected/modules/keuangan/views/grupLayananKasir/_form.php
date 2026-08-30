<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfgenerik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#KUGrouplayananM_grouplayanan_nama',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Grup Layanan Kasir</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'grouplayanan_nama',
                    'model' => $model,
                    'value' => $model->grouplayanan_nama,
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteDaftarTindakan') . '",
										   dataType: "json",
										   data: {
											   daftartindakan: request.term,
										   },
										   success: function (data) {
												   response(data);												   
										   }
									   })
									}',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
									 $(this).val("");
									 return false;
								 }',
                        'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									$(".daftartindakan_id").val(ui.item.daftartindakan_id);
									return false;
								}',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogGrupLayanan'),
                    'htmlOptions' => array(
                        'class' => 'required', 'placeholder' => 'Nama Grup Layanan', 'rel' => 'tooltip', 'title' => 'Ketik Nama Grup Layanan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'grouplayanan_id', array('class' => 'required',)); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Daftar Tindakan</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'daftartindakan_nama',
                    'model' => $model,
                    'value' => $model->daftartindakan_nama,
                    'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutocompleteDaftarTindakan') . '",
													   dataType: "json",
													   data: {
														   daftartindakan: request.term,
													   },
													   success: function (data) {
															   response(data);
															   setTarifDet();
													   }
												   })
												}',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
												 $(this).val("");
												 return false;
											 }',
                        'select' => 'js:function( event, ui ) {
												$(this).val( ui.item.value);
												$(".daftartindakan_id").val(ui.item.daftartindakan_id);
												return false;
											}',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogdaftartindakan'),
                    'htmlOptions' => array(
                        'class' => 'required', 'placeholder' => 'Uraian Tindakan', 'rel' => 'tooltip', 'title' => 'Ketik Uraian Tindakan untuk Mencari Daftar Tindakan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'daftartindakan_id', array('class' => 'required',)); ?>
            </div>
        </div>

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
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Grup Layanan Kasir', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogdaftartindakan',
    'options' => array(
        'title' => 'Pencarian Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modDaftarTindakan = new DaftartindakanM('search');
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['DaftartindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['DaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftartindakan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modDaftarTindakan->searchGrupLayananTindakan(),
    'filter' => $modDaftarTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($model) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectbarang",
                        "onclick" => '
										$("#daftartindakan_nama").val("' . $data->daftartindakan_nama . '");
										$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(' . $data->daftartindakan_id . ');
										$("#dialogdaftartindakan").dialog("close");'

                    )
                );
            },
        ),
        'daftartindakan_kode',
        'daftartindakan_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>

<?php
/* ====================================== Widget Dialog Group Layanan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGrupLayanan',
    'options' => array(
        'title' => 'Pencarian Grup Layanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modDaftarTindakan = new KUGrouplayananM('search');
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['KUGrouplayananM'])) {
    $modDaftarTindakan->attributes = $_GET['KUGrouplayananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modDaftarTindakan->searchGrupLayanan(),
    'filter' => $modDaftarTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($model) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectbarang",
                        "onclick" => '
										$("#grouplayanan_nama").val("' . $data->grouplayanan_nama . '");
										$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(' . $data->grouplayanan_id . ');
										$("#dialogGrupLayanan").dialog("close");'

                    )
                );
            },
        ),
        'grouplayanan_kode',
        'grouplayanan_nama',
        array(
            'header' => 'Pengelompokkan',
            'value' => function ($data) {
                if ($data->is_oa == true) {
                    return 'Jenis Obat dan Alkes';
                } else {
                    return 'Tindakan';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>