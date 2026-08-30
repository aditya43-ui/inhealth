<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - untuk memanggil dialog box 
 * @website      <http://>
 * RSST-1471
 */

/** =============== Pengirima Start ===================== **/
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPetugas',
        'options' => array(
            'title' => 'Pencarian Petugas',
            'autoOpen' => false,
            'width' => 530,
            'height' => 680,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$pegPengirim = new PegawairuanganV('search');
if (isset($_GET['PegawairuanganV'])) {
    $pegPengirim->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-pengirim-m-grid',
    'dataProvider' => $pegPengirim->searchDialogPegRuangan(),
    'filter' => $pegPengirim,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setPetugas(\"" . $data->namaLengkap . "\"," . $data->pegawai_id . "); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            },
            'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END Pengirim =======================================

//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKunjungan',
    'options' => array(
        'title' => 'Pencarian Data No. Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 650,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new BDInfopermintaandarahpasien('searchInformasiDialog');
$modDialogKunjungan->unsetAttributes();
if (isset($_GET['BDInfopermintaandarahpasien'])) {
    $modDialogKunjungan->attributes = $_GET['BDInfopermintaandarahpasien'];
    $modDialogKunjungan->no_pendaftaran = isset($_GET['BDInfopermintaandarahpasien']['no_pendaftaran']) ? $_GET['BDInfopermintaandarahpasien']['no_pendaftaran'] : '';
    $modDialogKunjungan->no_rekam_medik = isset($_GET['BDInfopermintaandarahpasien']['no_rekam_medik']) ? $_GET['BDInfopermintaandarahpasien']['no_rekam_medik'] : '';
    $modDialogKunjungan->no_rekam_medik = isset($_GET['BDInfopermintaandarahpasien']['no_rekam_medik']) ? $_GET['BDInfopermintaandarahpasien']['no_rekam_medik'] : '';
    $modDialogKunjungan->jeniskelamin = isset($_GET['BDInfopermintaandarahpasien']['jeniskelamin']) ? $_GET['BDInfopermintaandarahpasien']['jeniskelamin'] : '';
    $modDialogKunjungan->carabayar_id = isset($_GET['BDInfopermintaandarahpasien']['carabayar_id']) ? $_GET['BDInfopermintaandarahpasien']['carabayar_id'] : '';
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchInformasiDialog(),
    'filter' => $modDialogKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $data->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                $data->tanggal_lahir = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectKunjungan",
                    "onClick" => "                                            
                                            $(\"#BDPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#BDPendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#BDPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#BDPendaftaranT_kelaspelayanan_nama\").val(\"$data->kelaspelayanan_nama\");
                                            $(\"#BDPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
                                            $(\"#BDPasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#BDPasienM_alamat_pasien\").val(\"$data->alamat_pasien\");
                                            $(\"#BDPendaftaranT_diagnosa_nama\").val(\"$data->diagnosis\");
                                            $(\"#BDPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#BDPendaftaranT_umur\").val(\"$data->umur\");
                                            $(\"#BDPasienM_tanggal_lahir\").val(\"$data->tanggal_lahir\");
                                            $(\"#BDPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#BDPasienM_golongandarah\").val(\"$data->golongandarah\");
                                            $(\"#BDPendaftaranT_namaLengkap\").val(\"$data->nama_pegawai\");
                                            $(\"#BDUjidarahpasienT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#BDUjidarahpasienT_permintaandarah_id\").val(\"$data->permintaandarah_id\");
                                            $(\"#BDUjidarahpasienT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "
                ));
            },
        ),
        array(
            'header' => 'No. Permintaan',
            'name' => 'no_permintaandarah'
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
            'filter' => CHtml::dropDownList('PendaftaranLaboratoriumRujukanRS[jeniskelamin]', $modDialogKunjungan->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Jenis Penjamin',
            'filter' => CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', Chtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
            'name' => 'carabayar_id',
            'value' => function ($data) {
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
