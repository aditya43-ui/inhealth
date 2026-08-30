<?php
$ruangan_id = $pendaftaran->ruangan_id;
$kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
$penjamin_id = $pendaftaran->penjamin_id;

if (!empty($pendaftaran->pasienadmisi_id)) {
    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
    $ruangan_id = $admisi->ruangan_id;
    $kelaspelayanan_id = $admisi->kelaspelayanan_id;
    $penjamin_id = $admisi->penjamin_id;
}

$ruangan = RuanganM::model()->findByPk($ruangan_id);
$kelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);
$permintaan = PermintaandarahT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));

if (empty($ruangan)) {
    $ruangan = new RuanganM;
}

if (empty($kelas)) {
    $kelas = new KelaspelayananM;
}

$diagnosapasien = PasienmorbiditasT::model()->findByAttributes(array(
    'pendaftaran_id' => $pendaftaran->pendaftaran_id,
    'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
));

$penjamin = PenjaminpasienM::model()->findByPk($penjamin_id);

if (empty($penjamin)) {
    $penjamin = new PenjaminpasienM;
}

if (empty($pendaftaran->pasien)) {
    $pendaftaran->pasien = new PasienM;
}

if (empty($pendaftaran->pegawai)) {
    $pendaftaran->pegawai = new PegawaiM;
}

$diagnosa_nama = "";
if (!empty($diagnosapasien)) {
    $diagnosa = DiagnosaM::model()->findByPk($diagnosapasien->diagnosa_id);
    $diagnosa_nama = $diagnosa->diagnosa_kode . " " . $diagnosa->diagnosa_nama;
}
?>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No.</label>
        <div class="controls">
            <?php

            echo CHtml::activeHiddenField($model, 'permintaandarah_id', array(
                'class' => 'permintaandarah_id'
            ));
            echo CHtml::activeHiddenField($model, 'ujidarahtube_id', array(
                'class' => 'ujidarahtube_id'
            ));

            if (!empty($permintaan->permintaandarah_id)) {
                echo CHtml::textField('no_permintaan', $permintaan->no_permintaandarah, array('readonly' => true));
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'no_permintaandarah',
                    'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('autoCompletePermintaanDarah') . '",
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
                                $(this).val("");
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                setPermintaan(ui.item);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 peg_referal_nama',
                        'disabled' => !$model->isNewRecord,
                        'placeholder' => 'No.',
                    ),
                    'tombolDialog' => !$model->isNewRecord ? null : array('idDialog' => 'dialogPermintaan'),
                ));
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tgl. Pendaftaran</label>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran', $pendaftaran->no_pendaftaran, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">No. Pendaftaran</label>
        <div class="controls">
            <?php echo CHtml::textField('no_pendaftaran', MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran), array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Ruangan</label>
        <div class="controls">
            <?php echo CHtml::textField('ruangan', $ruangan->ruangan_nama, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Kelas Pelayanan</label>
        <div class="controls">
            <?php echo CHtml::textField('kelaspelayanan', $kelas->kelaspelayanan_nama, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Diagnosis</label>
        <div class="controls">
            <?php
            if (empty($permintaan->diagnosis)) { ?>
                <input readonly="readonly" type="text" value="-" name="penjamin" id="penjamin">
            <?php } else {
                echo CHtml::textField('diagnosis', $permintaan->diagnosis, array('readonly' => true));
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Penjamin</label>
        <div class="controls">
            <?php echo CHtml::textField('penjamin', $penjamin->penjamin_nama, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alamat Pasien</label>
        <div class="controls">
            <?php echo CHtml::textArea('alamatpasien', $pendaftaran->pasien->alamat_pasien, array('readonly' => true)); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No Rekam Medis</label>
        <div class="controls">
            <?php echo CHtml::textField('no_rekam_medik', $pendaftaran->pasien->no_rekam_medik, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama Pasien</label>
        <div class="controls">
            <?php echo CHtml::textField('nama_pasien', $pendaftaran->pasien->namadepan . $pendaftaran->pasien->nama_pasien, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal lahir</label>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir', MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir), array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Umur</label>
        <div class="controls">
            <?php echo CHtml::textField('umur', $pendaftaran->umur, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Jenis Kelamin</label>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin', $pendaftaran->pasien->jeniskelamin, array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Dokter yang Menangani</label>
        <div class="controls">
            <?php echo CHtml::textField('doktermenangani', $pendaftaran->pegawai->namaLengkap, array('readonly' => true)); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPermintaan',
    'options' => array(
        'title' => 'Daftar Permintaan Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPermintaan = new BDPasienmasukpenunjangT();
$modPermintaan->unsetAttributes();  // clear any default values
$format = new MyFormatter();
if (isset($_GET['BDInfopermintaandarahpasien'])) {
    $modPermintaan->attributes = $_GET['BDInfopermintaandarahpasien'];
    $modPermintaan->jeniskelamin = $_GET['BDInfopermintaandarahpasien']['jeniskelamin'];
    $modPermintaan->alamat_pasien = $_GET['BDInfopermintaandarahpasien']['alamat_pasien'];
    $modPermintaan->no_rekam_medik = $_GET['BDInfopermintaandarahpasien']['no_rekam_medik'];
    $modPermintaan->nama_pasien = $_GET['BDInfopermintaandarahpasien']['nama_pasien'];
    $modPermintaan->no_pendaftaran = $_GET['BDInfopermintaandarahpasien']['no_pendaftaran'];
    // $modPermintaan->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_awal']);
    // $modPermintaan->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_akhir']);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaandarah-grid',
    'dataProvider' => $modPermintaan->searchInformasiDaftarPengujianDarahDialog(),
    'filter' => $modPermintaan,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {

            

                return CHtml::Link('<i class="icon-form-check"></i>', '#', array(
                    'class' => 'btn-small',
                    'id' => 'selectBahan',
                    'onClick' => '
                   
                    $("#dialogPermintaan").dialog("close");
                    return false;'
                ));
            },
        ),
        array(
            'header' => 'Tanggal Pendaftaran',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
            },
        ),
        array(
            'header' => 'Nomor Pendaftaran',
            'name' => 'no_pendaftaran',
            'value' => function ($data) {
                return $data->no_pendaftaran;
            },
        ),
        array(
            'header' => 'Tanggal Permintaan',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_kirimpasien);
            }
        ),
        array(
            'header' => 'No. Formulir',
            // 'name' => 'no_permintaandarah',
            'value' => function ($data) {
                // return $data->no_permintaandarah;
            }
        ),
        array(
            'header' => 'Ruangan / DPJP ',
            'value' => function ($data) {
                echo $data->ruangan_nama . " / " . $data->dpjp_nama;
            }
        ),
        array(
            'header' => 'No. RM',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($modPermintaan, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Alamat',
            'name' => 'alamat_pasien',
            'value' => '$data->alamat_pasien',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>