<div class="row-fluid">
    <div class="col-sm-6">

        <?php echo $form->textFieldRow($model, 'bahasilpemeriksaanpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Termin <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_terminjumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label> dari</label>
                <?php echo $form->textField($model, 'termin_termintotal', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'termin_persen', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bahasilpemeriksaanpekerjaan_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bahasilpemeriksaanpekerjaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bahasilpemeriksaanpekerjaan_tanggal'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bapemeriksaanpekerjaan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    if (!empty($_GET['bahasilpemeriksaanpekerjaan_id'])) {
                        echo $form->textField($model, 'nomor_beritaacara_pemeriksaanpekerjaan', array('readonly' => true));
                        echo $form->hiddenField($model, 'bapemeriksaanpekerjaan_id', array('readonly' => true));
                    } else {
                        echo $form->dropDownList($model, 'bapemeriksaanpekerjaan_id', BapemeriksaanpekerjaanT::model()->getPemeriksaanPekerjaan($_GET['suratperjanjiankerja_id']),
                        array(
                            'empty'=>'-- Pilih --',
                            'readonly'=>false, 
                            'class'=>'span4',
                            'onchange'=>'ubahPemeriksaan(this);',
                        ));   
                    }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bahasilpemeriksaanpekerjaan_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
        
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">

        <p><h4><b>PIHAK KESATU</b></h4></p>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegpihakkesatu_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                <?php
                echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'jabatan_pihakkesatu', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kesatu')); ?>

    </div>
    <div class="col-sm-6">

        <p><h4><b>PIHAK KEDUA</b></h4></p>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Penyedia', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true)); ?>
                <?php echo CHtml::textField('penyedia', isset($modPeriksaKerja->supplier->supplier_nama) ? $modPeriksaKerja->supplier->supplier_nama : "", array('class' => 'span4', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Direktur', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('direktur', isset($modPeriksaKerja->supplier->direktursupplier) ? $modPeriksaKerja->supplier->direktursupplier : "", array('class' => 'span4', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group loaddata">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('alamat', isset($modPeriksaKerja->supplier->supplier_alamat) ? $modPeriksaKerja->supplier->supplier_alamat : "", array('class' => 'span4', 'readonly' => true)); ?>
            </div>
            <?php echo $form->hiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'total_dibulatkan', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemeriksaan',
    'options' => array(
        'title' => 'Pencarian Data Pemeriksaan Pekerjaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPemeriksaan = new BapemeriksaanpekerjaanT('search');
$modPemeriksaan->unsetAttributes();
if (isset($_GET['BapemeriksaanpekerjaanT'])) {
    $modPemeriksaan->attributes = $_GET['BapemeriksaanpekerjaanT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemeriksaanpekerjaan-grid',
    'dataProvider' => $modPemeriksaan->search(),
    'filter' => $modPemeriksaan,
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
                    setLampiran(\"$data->bapemeriksaanpekerjaan_id\");
                    $(\"#' . CHtml::activeId($model, 'bapemeriksaanpekerjaan_id') . '\").val(\"$data->bapemeriksaanpekerjaan_id\");
                    $(\"#' . CHtml::activeId($model, 'nomor_beritaacara_pemeriksaanpekerjaan') . '\").val(\"$data->bapemeriksaanpekerjaan_nomor\");
                    $(\"#dialogPemeriksaan\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'name' => 'bapemeriksaanpekerjaan_nomor',
            'value' => '$data->bapemeriksaanpekerjaan_nomor',
        ),
        array(
            'name' => 'nomor_beritaacara',
            'value' => '$data->nomor_beritaacara',
        ),
        array(
            'name' => 'bapemeriksaanpekerjaan_tanggal',
            'value' => '$data->bapemeriksaanpekerjaan_tanggal',
            'filter' => false,
        ),
        array(
            'name' => 'pa_nomorsk',
            'value' => '$data->pa_nomorsk',
        ),
        array(
            'name' => 'lokasi_pemeriksaan',
            'value' => '$data->lokasi_pemeriksaan',
        ),
        array(
            'name' => 'bapemeriksaanpekerjaan_hasil',
            'value' => '$data->bapemeriksaanpekerjaan_hasil',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPihak1',
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

$modPihak1 = new PegawaiV('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak1->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkesatu-grid',
    'dataProvider' => $modPihak1->search(),
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
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nip') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_alamat') . '\").val(\"$data->alamat_pegawai\");
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
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'jabatan_id', CHtml::listData(
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

<script>

    function cekPemeriksaan(obj) {
        if ($(obj).val() == "") {
            $("#<?= CHtml::activeId($model, 'bapemeriksaanpekerjaan_id'); ?>").val('');
            $("#<?= CHtml::activeId($model, 'nomor_beritaacara_pemeriksaanpekerjaan'); ?>").val('');
        }
    }

</script>