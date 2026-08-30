<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfjenis-obat-alkes-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#GFJenisObatAlkesM_jenisobatalkes_nama',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisobatalkes_nama', array('placeholder' => 'Nama Jenis Obat Alkes', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jenisobatalkes_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->checkBoxRow($model, 'jenisobatalkes_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Grup Layanan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo Chtml::label('Grup Layanan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'grouplayanan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'grouplayanan_nama',
                            'source' => 'js: function(request, response) {
													$.ajax({
															url: "' . $this->createUrl('/ActionAutoComplete/JenisObatAlkes') . '",
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
																	$(this).val( ui.item.value);
																	return false;
																						}',
                                'select' => 'js:function( event, ui ) { 
																								$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(ui.item.grouplayanan_id);
																								$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val(ui.item.grouplayanan_nama);
																								return false;
																						}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Grup Layanan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => '',
                                'onblur' => 'cekJenisGrupLayanan();'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogGroupLayanan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
/* ====================================== Widget Dialog Group Layanan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGroupLayanan',
    'options' => array(
        'title' => 'Pencarian Grup Layanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modGroupLayanan = new GrouplayananM('search');
$modGroupLayanan->unsetAttributes();
if (isset($_GET['GrouplayananM'])) {
    $modGroupLayanan->attributes = $_GET['GrouplayananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modGroupLayanan->searchGrupLayanan(),
    'filter' => $modGroupLayanan,
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
										$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val("' . $data->grouplayanan_nama . '");
										$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(' . $data->grouplayanan_id . ');
										$("#dialogGroupLayanan").dialog("close");'
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
            },
            'filter' => CHtml::activeDropDownList($modGroupLayanan, 'is_oa', array('is_oa' => 'Jenis Obat dan Alkes', 'is_tindakan' => 'Tindakan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('GFJenisObatAlkesM_jenisobatalkes_namalain').value = nama.value.toUpperCase();
    }

    function cekJenisGrupLayanan() {
        var gruplayanan = $("#<?php echo Chtml::activeId($model, 'grouplayanan_nama'); ?>").val();

        if (gruplayanan != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'grouplayanan_id'); ?>").val('');
        }
    }
</script>