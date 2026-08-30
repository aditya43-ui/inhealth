<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppjadwal-hemodialisa-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pasien')
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_awal)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
            <?php echo CHtml::activeHiddenField($model, 'pasien_id', array('readonly' => true)); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4'));
                /*$this->widget('MyJuiAutoComplete', array(
                    'name' => 'nama_pasien',
        //					'attribute'=>'pasien_id',
                    'model' => $model,
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePasien') . '",
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
                        'focus' => 'js:function( event, ui )
                                                                   {
                                                                    $(this).val(ui.item.label);
                                                                    return false;
                                                                    }',
                        'select' => 'js:function( event, ui ) {
                                                                   $(\'#nama_pasien\').val(ui.item.label);
                                                                   $(\'#PPJadwalhemodialisaT_pasien_id\').val(ui.item.pasien_id);
                                                                    return false;
                                                                }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Nama Pasien',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien'),
                ));*/
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Rekam Medik', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 numberOnly', 'maxlength' => 8));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jadwal Hari', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'jadwalhari_id', CHtml::listData($model->getJadwalHariItems(), 'jadwalhari_id', 'jadwalhari_nama'), array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'onchange' => '$("#inputForm").html("");',
                    'ajax' => array(
                        'url' => $this->createUrl('ajaxListHari'),
                        'type' => 'POST',
                        //                                    'update'=>'#inputHari')
                    )
                ));
                ?>
            </div>
            &nbsp;&nbsp;&nbsp;<span id="inputHari" class="form-inline"></span>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Shift', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData($model->getShiftItems(), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php $controller = Yii::app()->controller->id; ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/Index'), array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'return refreshForm(this);'
    ));
    echo ' ';
    ?>
    <?php
    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
//Dialog Nama Pasien
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Nama Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));
$format = new MyFormatter();
$modPasien = new PPPasienM;
$modPasien->unsetAttributes();
if (isset($_GET['PPPasienM'])) {
    $modPasien->attributes = $_GET['PPPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-grid',
    'dataProvider' => $modPasien->searchDialog1(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectPasien",
                                        "onClick" => "\$(\"#PPJadwalhemodialisaT_pasien_id\").val(\"$data->pasien_id\"); 
										\$(\"#nama_pasien\").val(\"$data->nama_pasien\");
                                                              \$(\"#dialogPasien\").dialog(\"close\");
                                                              "
                                ))',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
            'filter' => CHtml::activeTextField($modPasien, 'no_rekam_medik'),
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->nama_pasien',
            'filter' => CHtml::activeTextField($modPasien, 'nama_pasien'),
        ),
        array(
            'header' => 'Jenis Kelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeTextField($modPasien, 'jeniskelamin'),
        ),
        array(
            'header' => 'Tanggal Lahir',
            'value' => '$data->tanggal_lahir',
            //			'filter' => CHtml::activeTextField($modPasien, 'jeniskelamin'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$js = <<< JS
$('.numberOnly').keyup(function() {
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
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>