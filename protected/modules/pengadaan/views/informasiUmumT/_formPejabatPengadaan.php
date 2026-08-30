<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label("Pengguna Anggaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kuasa Pengguna Anggaran <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegkpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pejabat Pembuat Komitmen <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegppk_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php if(!empty($model->pegpengadaan_id)) :?>
        <div class="control-group ">
            <?php echo CHtml::label("Pejabat Pengadaan <span class='required'>*</span>", 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpengadaan_id'); ?>
                <?php echo $form->textField($model, 'pegpengadaan_nama', array('class' => 'span4','readonly' => true)); ?>
                <?php echo $form->hiddenField($model, 'temp_file', array('class' => 'span4','readonly' => true)); ?>
                <?php
//                $this->widget('MyJuiAutoComplete', array(
//                    'model' => $model,
//                    'attribute' => 'pegpengadaan_nama',
//                    'source' => 'js: function(request, response) {
//                        $.ajax({
//                            url: "' . $this->createUrl('getPegawai') . '",
//                            dataType: "json",
//                            data: {
//                                term: request.term,
//                            },
//                            success: function (data) {
//                                response(data);
//                            }
//                        })
//                     }',
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 2,
//                        'focus' => 'js:function( event, ui ) {
//                            $(this).val( ui.item.nama_pegawai);
//                            return false;
//                        }',
//                        'select' => 'js:function( event, ui ) {
//                            $("#InfoumumpengadaanT_pegpengadaan_id").val(ui.item.pegawai_id);
//                            $("#InfoumumpengadaanT_pegpengadaan_nama").val(ui.item.nama_pegawai);
//                            $("#InfoumumpengadaanT_jabatan_pengadaan").val(ui.item.jabatan_pengadaan);
//                            $("#InfoumumpengadaanT_tgl_sk").val(ui.item.tgl_sk);
//                            $("#InfoumumpengadaanT_no_sk").val(ui.item.no_sk);
//                            return false;
//                        }',
//                    ),
//                    'htmlOptions' => array(
//                        'class' => 'span4 required',
//                        'onkeypress' => "return $(this).focusNextInputField(event)",
//                        'placeholder' => 'Ketikan Nama Pejabat Pengadaan',
//                    ),
//                    'tombolDialog' => array('idDialog' => 'dialogPihak1', 'idTombol' => 'tombolPihak1'),
//                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jabatan <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jabatan_pengadaan', array('readonly' => $disablePejabat, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Nomor SK <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_sk', array('readonly' => $disablePejabat, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div> 
        <div class="control-group ">
            <?php echo CHtml::label("Tanggal SK <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_sk',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => $disablePejabat, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
            </div>
        </div>
        <?php endif;?>
        <div class="control-group">
            <?php echo CHtml::label("Nomor Referensi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_referensi', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">                               
                <?php echo CHtml::label("Dokumen Pendukung ",'',array('class' => 'control-label ')); ?>
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('accept'=>'application/pdf','class' => 'span4 ', 'Hint'=>'Isi Jika Akan Menambahkan File lampiran')); ?>               
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'',array('class' => 'control-label ')); ?>
            <div class="controls">
                <p style="color: red">Hanya file dengan ekstensi PDF, Max 3Mb.</p> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'',array('class' => 'control-label ')); ?>
            <div class="controls">
                <?php 
                    if (!empty($model->dokumen_pendukung)) {
                        echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('unduhDokumen', array('infoumumpengadaan_id' => $model->infoumumpengadaan_id)), array('title' => 'Unduh Dokumen Penduung', 'rel' => 'tooltip')) . '</td>'; 
                    } else {
                        echo "Belum ada Dokumen Pendukung";
                    }
                ?>            
            </div>
        </div>
    
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPihak1',
    'options' => array(
        'title' => 'Pencarian Pejabat Pengadaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PejabatpengadaanM('search');
$modPihak1->unsetAttributes();
$modPihak1->pejabatpengadaan_aktif = true;
if (isset($_GET['PejabatpengadaanM'])) {
    $modPihak1->attributes = $_GET['PejabatpengadaanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkesatu-grid',
    'dataProvider' => $modPihak1->searchDialog(),
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
                    $(\"#' . CHtml::activeId($model, 'pegpengadaan_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpengadaan_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'jabatan_pengadaan') . '\").val(\"$data->jabatan_pengadaan\");
                    $(\"#' . CHtml::activeId($model, 'tgl_sk') . '\").val(\"$data->tgl_sk\");
                    $(\"#' . CHtml::activeId($model, 'no_sk') . '\").val(\"$data->no_sk\");
                    $(\"#dialogPihak1\").dialog(\"close\"); 
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
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->pegawai->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPihak1, 'jabatan_pengadaan'),
            'value' => '$data->jabatan_pengadaan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>