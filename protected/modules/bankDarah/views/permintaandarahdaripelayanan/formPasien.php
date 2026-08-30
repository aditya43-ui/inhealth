<?php
if (!empty($_GET['permintaandarah_id'])) {
    $pasien_id = $modPermintaanDarah->pasien_id;
}
if(!empty($modPendaftaran)) {
    $modPermintaanDarah->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPermintaanDarah->pasien_id = $modPendaftaran->pasien_id;
}
?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id ?? '');
            echo CHtml::hiddenField('pasien_id', $modPendaftaran->pasien_id ?? '');
            echo $form->hiddenField($modPermintaanDarah, 'pasien_id', array('class' => 'required'));
            echo $form->hiddenField($modPermintaanDarah, 'pendaftaran_id');

            echo CHtml::hiddenField('pasien_id');
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'no_pendaftaran',
                'value' => $modPendaftaran->no_pendaftaran ?? '',
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.no_pendaftaran);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogKunjungan'),
                'htmlOptions' => array('placeholder' => 'Ketik No. Pendaftaran', 'class' => 'all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Tgl Pendaftaran', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('Tgl_pendaftaran', $modPendaftaran->tgl_pendaftaran ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('ruangan', $modPendaftaran->ruangan->ruangan_nama ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Kelas Pelayanan', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('kelaspelayanan', $modPendaftaran->kelaspelayanan->kelaspelayanan_nama ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Penjamin', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('penjamin', $modPendaftaran->penjamin->penjamin_nama ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Alamat Pasien', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textArea('alamat_pasien', $modPendaftaran->pasien->alamat_pasien ?? '', array('readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
            <?php echo CHtml::label('No rekam medik', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('no_rekam_medik', $modPendaftaran->pasien->no_rekam_medik ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('nama_pasien', $modPendaftaran->pasien->nama_pasien ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Tgl Lahir', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('tgl_lahir', $modPendaftaran->pasien->tanggal_lahir ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Umur', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('umur', $modPendaftaran->umur ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('jenis_kelamin', $modPendaftaran->pasien->jeniskelamin ?? '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Gol. Darah/Rhesus', '', array('class' => 'control-label')); ?>
        <div class="controls">
<?php echo CHtml::textField('gol_darah', $modPendaftaran->pasien->golongandarah ?? '', array('class' => 'span1', 'readonly' => true)); ?>
            <label>/</label> 
        </div>
        <div class="controls">
<?php echo CHtml::textField('rhesus', $modPendaftaran->pasien->rhesus ?? '', array('class' => 'span1', 'readonly' => true)); ?>
        </div>
    </div>


</div>

<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKunjungan',
    'options' => array(
        'title' => 'Pencarian Data No Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new BDBukuregisterpasienV('search');
$modDialogKunjungan->unsetAttributes();
if (isset($_GET['BDBukuregisterpasienV'])) {
    $modDialogKunjungan->attributes = $_GET['BDBukuregisterpasienV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->search(),
    'filter' => $modDialogKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            $(\"#no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#Tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#ruangan\").val(\"$data->ruangan_nama\");
                                            $(\"#kelaspelayanan\").val(\"$data->kelaspelayanan_nama\");
                                            $(\"#penjamin\").val(\"$data->penjamin_nama\");
                                            setAlamat(\"$data->pasien_id\");
                                            $(\"#tgl_lahir\").val(\"$data->tanggal_lahir\");
                                            $(\"#umur\").val(\"$data->umur\");
                                            $(\"#jenis_kelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#gol_darah\").val(\"$data->golongandarah\");
                                            $(\"#rhesus\").val(\"$data->rhesus\");
                                            $(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#BDPermintaandarahT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#BDPermintaandarahT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
        ),
        'no_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => false,
        ),
        'no_rekam_medik',
        'nama_pasien',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '--Pilih--')),
        ),
        array(
            'header' => 'Jenis Penjamin',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', Chtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
            'name' => 'carabayar_id',
            'value' => function($data) {
                $j = CarabayarM::model()->findByPk($data->carabayar_id);

                if (!empty($j)) {
                    return $j->carabayar_nama;
                } else {
                    return '-';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>