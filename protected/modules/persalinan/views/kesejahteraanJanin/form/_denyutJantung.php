<div class="panel panel-success panel_monitor">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('cb_jantung', !$jantung->isNewRecord, array(
                'class'=>'cb_str', 'disabled'=> !$jantung->isNewRecord,
            )); ?>
            Denyut Jantung Janin</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($jantung, 'pemeriksaanke', array('class' => 'span1 numbers-only', 'readonly' => true)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($jantung, 'tgl_pemeriksaan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $jantung,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($jantung, 'jam_pemeriksaan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $jantung,
                            'attribute' => 'jam_pemeriksaan',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($jantung, 'denyutjantung_janin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($jantung, 'denyutjantung_janin', array(
                            'class' => 'numbers-only span1'
                        ));
                        ?> <label>x/menit</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($jantung, 'petugaspemeriksa_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($jantung, 'petugaspemeriksa_id', array('class' => 'jantung_petugaspemeriksa_id')); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'petugaspemeriksa_nama',
                            'value' => empty($jantung->petugaspemeriksa) ? "" : $jantung->petugaspemeriksa->namaLengkap,
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('autocompletePegawaiPemeriksa') . '",
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
                                        $(this).val("");
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        $(".jantung_petugaspemeriksa_id").val(ui.item.pegawai_id);
                                        $(".jantung_petugaspemeriksa_nama").val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'jantung_petugaspemeriksa_nama span3',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugasDenyutJantung'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasDenyutJantung',
    'options' => array(
        'title' => 'Petugas Pemeriksa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
$petugas = new PegawairuanganV('search');
$petugas->unsetAttributes();
$petugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $petugas->attributes = $_GET['PegawairuanganV'];
    //$petugas->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
    // $petugas->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
//    $petugas->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jantung-pemeriksa-grid',
    'dataProvider' => $petugas->searchPegawaiRuangan(),
    'filter' => $petugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'.jantung_petugaspemeriksa_id\').val($data->pegawai_id);
                                        $(\'.jantung_petugaspemeriksa_nama\').val(\'$data->namaLengkap\');
                                        $(\'#dialogPetugasDenyutJantung\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>