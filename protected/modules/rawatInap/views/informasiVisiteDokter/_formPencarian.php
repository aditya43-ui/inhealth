<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarvisitedokter-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Visite", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->dropDownListRow(
                $model,
                'kelaspelayanan_id',
                CHtml::listData($model->getKelaspelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)
            ); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokter_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'dokter_id', array()); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteDokter') . '",
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
                        'select' => 'js:function( event, ui ) {
                        $(this).val( ui.item.label);
                        $("#' . CHtml::activeId($model, 'dokter_id') . '").val( ui.item.pegawai_id);
                            return false;
                    }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter'),
                    'htmlOptions' => array(
                        'class' => 'span3 hurufs-only', "rel" => "tooltip", "placeholder" => "Dokter", 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'dokter_id') . '").val(""); '
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--fieldset class="box"-->
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $content = $this->renderPartial('tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));
$modDokter = new RIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
if (isset($_GET['RIDokterV'])) {
    $modDokter->attributes = $_GET['RIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#' . CHtml::activeId($model, 'dokter_id') . '\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
							$(\"#dialogDokter\").dialog(\"close\");
							return false;"
					))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter Resep',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . '     setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . '     setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>