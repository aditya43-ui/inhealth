<style>
    .form-horizontal .control-label{
        width: 140px !important;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bapemeriksaanadmpjphp_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor BA')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bapemeriksaanadmpjphp_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bapemeriksaanadmpjphp_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker4', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bapemeriksaanadmpjphp_tanggal'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_ke', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <label class="control-label" style="width: 35px !important">Dari</label>
            <div class="controls">
                <?php echo $form->textField($model, 'total_termin', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'terminke', array('class'=>'span1','readonly'=>true)); ?>
                <?php echo $form->hiddenField($model, 'termin_persen', array('class'=>'span1','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bapemeriksaanadmpjphp_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegpjphp_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpjphp_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegpjphp_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                            $(this).val( ui.item.nama_pegawai);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'pegpjphp_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'nomor_sk') . '").val(ui.item.no_sk); 
                            $("#' . Chtml::activeId($model, 'tanggal_sk') . '").val(ui.item.tgl_sk); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 namaPegawai',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegpjphp', 'idTombol' => 'tombolPegpjphp'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegttdkontrak_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegttdkontrak_id'); ?>
                <?php echo $form->textField($model, 'pegttdkontrak_nama', array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nomor_sk', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor SK', 'readonly'=>true)); ?>
        <?php echo $form->textFieldRow($model, 'tanggal_sk', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Tanggal SK','readonly'=>true)); ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegpjphp',
    'options' => array(
        'title' => 'Pencarian Pegawai PjPHP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PejabatpengadaanM('search');
$modPihak1->default = 'ada';
if (isset($_GET['PejabatpengadaanM'])) {
    $modPihak1->attributes = $_GET['PejabatpengadaanM'];
    $modPihak1->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai']) ? $_GET['PejabatpengadaanM']['nomorindukpegawai'] : null;
    $modPihak1->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai']) ? $_GET['PejabatpengadaanM']['nama_pegawai'] : null;
    $modPihak1->namaunitkerja = isset($_GET['PejabatpengadaanM']['namaunitkerja']) ? $_GET['PejabatpengadaanM']['namaunitkerja'] : null;
    $modPihak1->jabatan_nama = isset($_GET['PejabatpengadaanM']['jabatan_nama']) ? $_GET['PejabatpengadaanM']['jabatan_nama'] : null;
    $modPihak1->default = isset($_GET['PejabatpengadaanM']['default']) ? $_GET['PejabatpengadaanM']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pejabatpa-m-grid',
    'dataProvider' => $modPihak1->searchDialogPJPHP(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "selectObat",
                "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'pegpjphp_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpjphp_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'nomor_sk') . '\").val(\"$data->no_sk\");
                    $(\"#' . CHtml::activeId($model, 'tanggal_sk') . '\").val(\"$data->tgl_sk\");
                    $(\"#dialogPegpjphp\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPihak1, 'nomorindukpegawai'),
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->pegawai->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPihak1, 'jabatan_nama'),
            'value' => function($data) {
                if (empty($data->pegawai->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->pegawai->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeTextField($modPihak1, 'namaunitkerja'),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->pegawai->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPenandatanganKontrak',
    'options' => array(
        'title' => 'Pencarian Pegawai Pihak Kesatu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak2 = new PegawaiM('search');
$modPihak2->unsetAttributes();
$modPihak2->pegawai_aktif = true;
if (isset($_GET['PegawaiM'])) {
    $modPihak2->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkedua-grid',
    'dataProvider' => $modPihak2->search(),
    'filter' => $modPihak2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "selectObat",
                "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'pegttdkontrak_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegttdkontrak_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#dialogPenandatanganKontrak\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak2, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak2, 'jabatan_id', CHtml::listData(
                            JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
                    ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>